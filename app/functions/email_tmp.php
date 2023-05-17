<?php   
    
        

    function wEmailHeader()
    {
        $logo = URL.DS.'public/logo2.png';

        $COMPANY_NAME = COMPANY_NAME;

        $header = <<<EOF
            <div class="header" style="text-align: center;padding: 15px;background: #fff;">
                <div class="text-center" style="text-align: center;">
                    <img src="{$logo}" style="width:200px">
                    <h3 style="margin: 10px 0px;color:#21209C">{$COMPANY_NAME}</h3>
                </div>
            </div>
        EOF;

        return $header;
    }
    
    function wEmailFooter()
    {
        $logo = URL.DS.'public/logo2.png';

        $COMPANY_NAME = COMPANY_NAME;

        $footer = <<<EOF
            <div class="footer" style="text-align: center;padding: 15px;background:#0075F6; color:#fff">
                <h3 style="margin: 10px 0px;">{$COMPANY_NAME}</h3>
                <div style="color:#fff">
                    <small>
                        <i>The content of this email is confidential and intended for the recipient specified in message only. It is strictly forbidden to share any part of this message with any third party, without a written consent of the sender. If you received this message by mistake, please reply to this message and follow with its deletion, so that we can ensure such a mistake does not occur in the future.</i>
                    </small>
                </div>
            </div>
            <div style="height:15px;background:#50D890"> </div>
        EOF;

        return $footer;
    }

    function wEmailWrapper($content)
    {
        $wrapper = <<<EOF
            <div id="email_body" style="width: 800px;margin: 0px auto;font-family: tahoma , verdana , arial;">
                {$content}
            </div>
        EOF;

        return $wrapper;
    }

    function wEmailComplete($content)
    {
        $content = wEmailBody($content);
        $footer = wEmailFooter();
        $header = wEmailHeader();


        $bodyComplete = $header;
        $bodyComplete .= $content;
        $bodyComplete .= $footer;

        $empCompleteHTML = wEmailWrapper( $bodyComplete );

        return $empCompleteHTML;
    }

    /*
    *Contents : what will show on the email
    *styles : this will be the styles 
    */
    function wEmailBody( $content = '' , $styles = [] )
    {
        return <<<EOF
            <div style="margin: 0px auto;font-family: tahoma , verdana , arial;background: #fff; padding: 20px 30px;line-height:160%">
                {$content}
            </div>
        EOF;
    }