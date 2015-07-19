<?php
class SAjaxFunctions extends SAjax
{
    public function saveEmail($email)
    {
        $this->out('script','$("#nl_error, #nl_success").slideUp();');

        if (! Validator::email($email)) {
            $this->out('script','$("#nl_error").slideDown();');

            return false;
        }

        Db::query('INSERT INTO emails SET title = "'.Db::clean($email).'"');

        $this->out('script','$("#nl_email").val(""); $("#nl_success").slideDown();');

        return false;
    }
    
    public function contactForm($post)
    {
        $this->out('script', '$(".error").removeClass("error");');

        $errors = array();
        $req = array('name', 'email', 'phone');
        foreach ($req as $key) {
            $data[$key] = trim(filter_var($post[$key] ,FILTER_SANITIZE_STRING));

            if ($data[$key] == '') {
                $errors[] = $key;
            }
        }

        if (! Validator::email($data['email']))
            $errors[] = 'email';

        if ($errors) {
            foreach ($errors as $field) {
                $this->out('script', '$("#'.$field.'").addClass("error");');
            }
        } else {
            $msg = '
                <p><strong>InfinitySQUARED website contact form</strong></p>
                <p><strong>Name</strong> '.$data['name'].'</p>
                <p><strong>E-mail</strong> '.$data['email'].'</p>
                <p><strong>Phone</strong> '.$data['phone'].'</p>
                <p><strong>Question/Comment</strong></p>
                <p>'.nl2br($post['comment']).'</p>
                <p><strong>Best time to contact</strong></p>
                <p>'.nl2br($post['time']).'</p>
            ';

            Mailer::sendHtmlMail('no-reply@infinity2pro.com', Config::get('default_email'), 'InfinitySQUARED website contact form - Message from: '.$data['name'], $msg);

            $this->out('script', '$("#f_contact_us").remove();');
            $this->out('script', '$(".c2").append("<div class=\"success\">Thank you! Your message has been sent.</div>");');
        }

        return false;
    }

    public function adminChangeOrder($id, $table, $direction)
    {
        if (! User::isAdmin())
            return false;

        $id = (int)$id;

        $current = Db::query_one('SELECT order_number FROM '.Db::clean($table).' WHERE id = '.$id.' LIMIT 1');

        if ($direction == 'up') {
            $row_over = Db::query_row('SELECT id, order_number FROM '.Db::clean($table).' WHERE order_number > '.$current.' ORDER BY order_number ASC LIMIT 1');
            Db::query('UPDATE '.Db::clean($table).' SET order_number = "'.$row_over['order_number'].'" WHERE id = '.$id.' LIMIT 1');
            Db::query('UPDATE '.Db::clean($table).' SET order_number = "'.$current.'" WHERE id = '.$row_over['id'].' LIMIT 1');
        } else {
            $row_under = Db::query_row('SELECT id, order_number FROM '.Db::clean($table).' WHERE order_number < '.$current.' ORDER BY order_number DESC LIMIT 1');
            Db::query('UPDATE '.Db::clean($table).' SET order_number = "'.$row_under['order_number'].'" WHERE id = '.$id.' LIMIT 1');
            Db::query('UPDATE '.Db::clean($table).' SET order_number = "'.$current.'" WHERE id = '.$row_under['id'].' LIMIT 1');
        }

        $this->out('script', 'window.location.reload();');

        return false;
    }
    
    public function adminArticleActivationStatus($id)
    {
        if (! User::isAdmin())
            return false;

        $id = (int)$id;

        $status = Db::query_one('SELECT active FROM videos WHERE id = '.$id.' LIMIT 1');

        $newStatus = ($status == 'y') ? 'n' : 'y';

        Db::query('UPDATE videos SET active = "'.$newStatus.'" WHERE id = '.$id.' LIMIT 1');

        $this->out('script', '$("#a_active_'.$id.'").attr("class", "a_active_'.$newStatus.'");');

        return false;
    }

    public function adminDeleteImg($id)
    {
        if (! User::isAdmin())
            return false;

        $id = (int)$id;

        $path = Config::get('site_root').'storage/photos/';
        $file = Db::query_one('SELECT filename FROM files WHERE id = '.$id.' LIMIT 1');
        if ($file) {
            Db::query('DELETE FROM files WHERE id = '.$id.' LIMIT 1');
            @unlink($path.$file);
            @unlink($path.'thmb_'.$file);
        }

        $this->out('script', '$("#img_'.$id.'").remove();');

        return false;
    }

    public function adminRowDelete($id, $table)
    {
        if (! User::isAdmin())
            return false;

        $id = (int)$id;

        Db::query('DELETE FROM '.Db::clean($table).' WHERE id = '.$id.' LIMIT 1');

        $files = Db::query('SELECT filename FROM files WHERE table_name = "'.Db::clean($table).'" AND table_id = '.$id);
        if ($files) {
            $path = Config::get('site_root').'storage/photos/';
            foreach ($files as $k => $v) {
                @unlink($path.$v['filename']);
            }

            Db::query('DELETE FROM files WHERE table_name = "'.Db::clean($table).'" AND table_id = '.$id);
        }

        $this->out('script', '$("#tr_'.$id.'").remove();');

        return false;
    }
}