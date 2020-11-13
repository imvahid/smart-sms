<?php

namespace Va\SmartSms\Services;

class SmartSms
{
    protected $url;
    protected $line_number;
    protected $user_id;
    protected $password;
    protected $default_sms_rcpt;

    public function __construct()
    {
        $this->url = 'http://ws.smartsms.ir/sms.asmx?WSDL';
        $this->line_number = config('smart-sms.line_number');
        $this->user_id = config('smart-sms.user_id');
        $this->password = config('smart-sms.password');
        $this->default_sms_rcpt = config('smart-sms.default_sms_rcpt');
    }

    public function send($receptor, $message)
    {
        try{
            $this->soap()->__soapCall('XmsRequest', [ $this->sms($receptor, $message) ] );
        }catch (\Exception $e){
            throw $e;
        }
    }

    public function soap()
    {
        return new \SoapClient($this->url);
    }

    public function sms($receptor, $message)
    {
        $recipient = "";
        if (is_array($receptor)) {

            $sendType = "<type>oto</type>";
            foreach ($receptor as $item) {
                if (config('app.env') == 'local') {
                    $item = $this->default_sms_rcpt;
                }
                $recipient .= "<recipient mobile='{$item}' originator='{$this->line_number}'>{$message}</recipient>";
            }

        } else {

            $sendType = "<type>oto</type>";
            if (config('app.env') == 'local') {
                $receptor = $this->default_sms_rcpt;
            }
            $recipient = "<recipient mobile='{$receptor}' originator='{$this->line_number}'>{$message}</recipient>";

        }
        return [
            'requestData' => "
            <xmsrequest>
				<userid>{$this->user_id}</userid>
				<password>{$this->password}</password>
				<action>smssend</action>
				<body>
					{$sendType}
                    {$recipient}
                </body>
			</xmsrequest>
			"
        ];
    }
}
