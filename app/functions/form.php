<?php
    function f_text($name , $value = null , $attributes = null)
    {
        return Form::text($name , $value = null , $attributes = null);
    }

    function f_select($name , $values , $selected = null, $attributes = null)
    {
        return Form::select($name , $values , $selected = null, $attributes = null);
    }
    
    function f_label($html , $for = null, $attributes = null)
    {
        return Form::label($html , $for = null, $attributes = null);
    }

    function f_mall($html , $attributes = NULL)
    {
        return Form::small($html , $attributes = NULL);
    }

    function f_hidden($name , $value , $attributes = null)
    {
        return Form::hidden($name , $value , $attributes = null);
    }

    function f_number($name , $value = null , $attributes = null)
    {
        return Form::number($name , $value = null , $attributes = null);
    }

    function f_date($name , $value , $attributes)
    {
        return Form::date($name , $value , $attributes);
    }

    function f_textarea($name , $value = null , $attributes = null)
    {
        return Form::textarea($name , $value = null , $attributes = null);
    }

    function f_file($name, $attributes = null)
    {
        return Form::file($name, $attributes = null);
    }

    function f_submit($name , $value = null , $attributes = null)
    {
        return Form::submit($name , $value = null , $attributes = null);
    }

    function f_open(array $attributes)
    {
        return Form::open($attributes);
    }
    function f_close()
    {
        Form::close();
    }


    function _action_post($args)
    {
        if(is_array($args))
        {
            $data = $args;
            $data['method'] = 'post';

            return $data;
        }else{
            return [
                'method' => 'post',
                'action' => DS.$args,
                'id'     => 'form-create',
            ];
        }
        
    }


    function _form_create($formName = null)
    {
        $formName = $formName ?? 'form-create';

        $html = <<<EOF
            <button type="submit" form="$formName" class="btn btn-primary btn-sm mb-2"><i class="fa fa-save"></i></button>
        EOF;

        return $html;
    }

    function _form_delete($formName = null)
    {
        $formName =  $formName ?? 'form-delete';

        $html = <<<EOF
            <button type="submit" form="$formName" class="btn btn-danger btn-sm mb-2"><i class="fas fa-trash"></i></button>
        EOF;
        
        return $html;
    }