<?php
class Categories
{
    private static $tmpData = array();

    public static function getAllCategories($parentId = 0, $level = -1)
    {
        $level++;

        $data = Db::query('SELECT id, order_number, title FROM categories WHERE parent_id = '.(int)$parentId.' ORDER BY order_number ASC');

        if ($data) {
            foreach ($data as $k => $v) {
                self::$tmpData[$v['id']]['id'] = $v['id'];
                self::$tmpData[$v['id']]['order_number'] = $v['order_number'];
                self::$tmpData[$v['id']]['title'] = $v['title'];
                self::$tmpData[$v['id']]['level'] = $level;

                self::getAllCategories($v['id'], $level);
            }
        }

        // $ret = self::$tmpData;
        // self::$tmpData = array();

        return self::$tmpData;
    }

    // vraća array sa id-ovima svih parent kategorija od kategorije koje smo proslijedili id + id te kategorije
    function get_parent_categories($id, $table, $first=true)
    {
        $is_cat = Db::query_one('SELECT id FROM '.Db::clean($table).' WHERE id = '.(int)$id.' LIMIT 1');
        
        if( ! $is_cat )
            return false;
        
        static $ids = array();
        
        if( $first )
        {
            $ids = array();
            $ids[] = $id;
        }
        
        $cat = Db::query_one('SELECT parent_id FROM '.Db::clean($table).' WHERE id = '.(int)$id.' LIMIT 1');
        
        if( $cat )
        {
            $ids[] = (int)$cat;
            get_parent_categories($cat, $table, false);
        }
        
        return array_reverse($ids);
    }

    // vraća id-ove svih podkategorija od kategorije koje smo proslijedili id + id te kategorije
    function get_subcategories($id, $table, $first=true)
    {
        $is_cat = Db::query_one('SELECT id FROM '.Db::clean($table).' WHERE id = '.(int)$id.' LIMIT 1');
        
        if( ! $is_cat )
            return false;
        
        static $ids = array();
        
        if( $first )
        {
            $ids = array();
            $ids[] = $id;
        }
        
        $cat = Db::query('SELECT id FROM '.Db::clean($table).' WHERE parent_id = '.(int)$id);
        
        if( $cat )
        {
            foreach($cat as $k => $v)
            {
                $ids[] = (int)$v['id'];
                get_subcategories($v['id'], $table, false);
            }
        }
        
        return array_unique($ids);
    }
    
    function get_cat_sef_title($id, $table, $direction='down')
    {
        $lng = ( $_config['multi_language'] == 1 ) ? '_'._LNG : '' ;
        
        if( $direction == 'up' )
            $parents = get_parent_categories($id, $table);
        else
            $parents = get_subcategories($id, $table);
        
        $uri = '';
        $cnt = count($parents);
        $i = 0;
        foreach($parents as $k => $v)
        {
            $i++;
            $uri .= clean_uri(Db::query_one('SELECT title'.$lng.' FROM '.Db::clean($table).' WHERE id = '.(int)$v.' LIMIT 1'));
            
            $uri .= ( $i < $cnt ) ? '-' : '' ;
        }
        
        return $uri;
    }
}