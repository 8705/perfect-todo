<?php

/**
 * Response.
 *
 * @author Katsuhiro Ogawa <fivestar@nequal.jp>
 */
class Response
{
    protected $content;
    protected $status_code = 200;
    protected $status_text = 'OK';
    protected $http_headers = array();

    /**
     * レスポンスを送信
     */
    public function send()
    {

        header('HTTP/1.1 ' . $this->status_code . ' ' . $this->status_text);

        foreach ($this->http_headers as $name => $value) {
            header($name . ': ' . $value);
        }

        $header_info = array('status_code' => $this->status_code,
                             'status_text' => $this->status_text,
                             'content'     => $this->content
                             );
        $header_info = array_merge($header_info, $this->http_headers);
        return $header_info;
    }

    /**
     * コンテンツを設定
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * ステータスコードを設定
     *
     * @param integer $status_code
     * @param string $status_code
     */
    public function setStatusCode($code)
    {
        $status = array(200 => 'OK',
                        302 => 'Found',
                        404 => 'Not Found',
                        );
        if (array_key_exists($code, $status)) {
            $this->status_code = $code;
            $this->status_text = $status[$code];
        }
    }

    /**
     * HTTPレスポンスヘッダを設定
     *
     * @param string $name
     * @param mixed $value
     */
    public function setHttpHeader($name, $value)
    {
        $this->http_headers[$name] = $value;
    }
}
