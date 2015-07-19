<?php
class FormProcess
{
    private
        $table = false,
        $data = array(),
        $files = array(),
        $filesData = array(),
        $skip = array('skip_', 'photo_', 'file_', 'i_id'),
        $id = 0;

    public $dontResizePhotos = false;

    public function setData($data=false, $files=false)
    {
        if ($data) {
            foreach ($data as $k => $v) {
                $this->validateFieldName($k);

                if (substr($k,0,5) == 'file_') {
                    $this->filesData[$k] = $v;

                    continue 1;
                }

                if (in_array($k, $this->skip)) {
                    continue 1;
                }

                foreach ($this->skip as $skipPart) {
                    $l = strlen($skipPart);

                    if (substr($k, 0, strlen($skipPart)) == $skipPart) {
                        continue 2;
                    }
                }

                if ($k == 'i_id' && (int)$v > 0) {
                    $this->setId($v);

                    continue 1;
                }

                $this->data[$k] = $v;
            }
        }

        if ($files) {
            foreach ($files as $k => $v) {
                $this->validateFieldName($k);
            }

            $this->files = $files;
        }
    }

    public function setTable($table)
    {
        $this->validateFieldName($table);
        $this->table = $table;
    }

    public function save()
    {
        if ($this->id) {
            $this->update();
        } else {
            $this->create();
        }

        $this->handleFiles();
        $this->updateFilesData();

        return true;
    }

    private function create()
    {
        $sql = 'INSERT INTO '.$this->table.' SET '.$this->generateSQL();
        $q = Db::query($sql);

        if (! $q) {
            throw new Exception("Error Processing SQL", 12);
        }

        $this->id = Db::insert_id();
        $this->addOrderNumber();
    }

    private function update()
    {
        $sql = 'UPDATE '.$this->table.' SET '.$this->generateSQL().' WHERE id = '.$this->id;
        $q = Db::query($sql);

        if (! $q) {
            throw new Exception("Error Processing SQL", 13);
        }
    }

    public function getData()
    {
        $data = Db::query_row('SELECT * FROM '.$this->table.' WHERE id = '.$this->id);
        $files = Db::query('SELECT * FROM files WHERE type = "document" AND table_name = "'.$this->table.'" AND table_id = '.$this->id.' ORDER BY order_number ASC');
        $images = Db::query('SELECT * FROM files WHERE type = "photo" AND table_name = "'.$this->table.'" AND table_id = '.$this->id.' ORDER BY order_number ASC');

        return array('data'=>$data, 'files'=>$files, 'images'=>$images);
    }

    private function generateSQL()
    {
        if (! $this->data) {
            throw new Exception("There is no data to create SQL from", 15);
        }

        $sql = array('created = NOW()');

        foreach ($this->data as $k => $v) {
            $sql[] = $k.' = "'.Db::clean($v).'"';
        }

        return implode(', ', $sql);
    }

    private function handleFiles()
    {
        foreach ($this->files as $k => $v) {
            if (! $this->files[$k]['name']) {
                continue;
            }

            $type = (substr($k,0,6) == 'photo_') ? 'photo' : 'document' ;

            $saveTo = Config::get('site_root').'storage/'.$type.'s/';
            
            $filename = time().'_'.mt_rand(100,999).'_'.Strings::cleanUrl($this->files[$k]['name']);
            if(is_file($saveTo.$filename))
                $filename = mt_rand().'_'.$filename;

            move_uploaded_file($this->files[$k]['tmp_name'], $saveTo.$filename);

            if ($type == 'photo') {
                if (! $this->dontResizePhotos) {
                    Image::resize($saveTo.$filename, $saveTo.$filename, 1200, 1200, 80);
                }
                Image::resize($saveTo.$filename, $saveTo.'thmb_'.$filename, 400, 400, 80);
            }

            Db::query('INSERT INTO files SET filename = "'.$filename.'", table_name = "'.$this->table.'", table_id = '.$this->id.', type = "'.$type.'", created = NOW()');
            $fileId = Db::insert_id();
            Db::query('UPDATE files SET order_number = '.$fileId.' WHERE id = '.$fileId.' LIMIT 1');
        }
    }

    private function updateFilesData()
    {
        foreach ($this->filesData as $k => $v) {
            if (substr($k,0,11) == 'file_order_') {
                $id = (int)substr($k,11);
                Db::query('UPDATE files SET order_number = '.(int)$v.' WHERE id = '.$id.' LIMIT 1');
            }

            if (substr($k,0,11) == 'file_title_') {
                $id = (int)substr($k,11);
                Db::query('UPDATE files SET title = "'.Db::clean($v).'" WHERE id = '.$id.' LIMIT 1');
            }
        }
    }

    private function addOrderNumber()
    {
        Db::query('UPDATE '.$this->table.' SET order_number = '.$this->id.' WHERE id = '.$this->id.' LIMIT 1');
    }

    public function validateFieldName($fieldName)
    {
        if (! preg_match('/^[a-z0-9_]+$/', $fieldName)) {
            throw new Exception("Field/table name provided is invalid", 11);
        }
    }

    public function setId($id)
    {
        $this->id = (int)$id;
    }

    public function getId()
    {
        return $this->id;
    }
}