<?php 
// class MP3_data 
// { 
//      var $title;var $artist;var $album;var $year;var $comment;var $genre; 
//      function getid3 ($file) { 
//       if (file_exists($file)) { 
//        $id_start=filesize($file)-128; 
//        $fp=fopen($file,"r"); 
//        fseek($fp,$id_start); 
//        $tag=fread($fp,3); 
//        if ($tag == "TAG") { 
//         $this->title=fread($fp,30); 
//         $this->artist=fread($fp,30); 
//         $this->album=fread($fp,30); 
//         $this->year=fread($fp,4); 
//         $this->comment=fread($fp,30); 
//         $this->genre=bin2hex(fread($fp,1)); 
//         fclose($fp); 
//         return true; 
//        } else { 
//         fclose($fp); 
//         return false; 
//        } 
//       } else { return false; } 
//      } 
// }
// include("getid3/getid3.php");
// include("./getGenre.php");
// 			$mp3file=new MP3_data(); 
// 		$mp3file->getid3('test.mp3');

// 	//	include("getid3/getid3.php");
// 		$getID3 = new getID3; 
// 			// $ThisFileInfo = $getID3cut->analyze('/Insatiable.mp3');
// 					// $mp3file=new MP3_data(); 
// 		// $ThisFileInfo = $getID3->analyze($upload_directory."/" . $name); 
// 		// $mp3file->getid3('/Insatiable.mp3');
// 		var_dump($mp3file->genre);
// 		echo getGenre(hexdec($mp3file->genre));
// 		0.Blues
// 1.Classic Rock
// 2.Country
// 3.Dance
// 4.Disco
// 5.Funk
// 6.Grunge
// 7.Hip-Hop
// 8.Jazz
// 9.Metal
// 10.New Age
// 11.Oldies
// 12.Other
// 13.Pop
// 14.R&B
// 15.Rap
// 16.Reggae
// 17.Rock
// 18.Techno
// 19.Industrial
// 20.Alternative
// 21.Ska
// 22.Death Metal
// 23.Pranks
// 24.Soundtrack
// 25.Euro-Techno
// 26.Ambient
// 27.Trip-Hop
// 28.Vocal
// 29.Jazz+Funk
// 30.Fusion
// 31.Trance
// 32.Classical
// 33.Instrumental
// 34.Acid
// 35.House
// 36.Game
// 37.Sound Clip
// 38.Gospel
// 39.Noise
// 40.AlternRock
// 41.Bass
// 42.Soul
// 43.Punk
// 44.Space
// 45.Meditative
// 46.Instrumental Pop
// 47.Instrumental Rock
// 48.Ethnic
// 49.Gothic
// 50.Darkwave
// 51.Techno-Industrial
// 52.Electronic
// 53.Pop-Folk
// 54.Eurodance
// 55.Dream
// 56.Southern Rock
// 57.Comedy
// 58.Cult
// 59.Gangsta
// 60.Top 40
// 61.Christian Rap
// 62.Pop/Funk
// 63.Jungle
// 64.Native American
// 65.Cabaret
// 66.New Wave
// 67.Psychadelic
// 68.Rave
// 69.Showtunes
// 70.Trailer
// 71.Lo-Fi
// 72.Tribal
// 73.Acid Punk
// 74.Acid Jazz
// 75.Polka
// 76.Retro
// 77.Musical
// 78.Rock & Roll
// 79.Hard Rock]
// function getPitch($filePath)
// {
//       $filePath = escapeshellarg($filePath);
//       $output = [];
//       exec('/usr/local/bin/aubiopitch -i '.$filePath.' -l 0.4' , $output, $return_var);
//       // var_dump(count($output));
//       // array_walk($output, 'removeTime');
//       for ($i=0; $i < count($output); $i++) { 
//         // $output[$i] =  round(removeTime($output[$i]));
//            $pieces = explode(" ", $output[$i]);
//            $output[$i] = round($pieces[1]);
//       }
//       $count =0;
//       $sum = 0;
//       for ($x=0; $x <count($output) ; $x++) { 
//         if($output[$x]>200)
//         {
//            $sum = $sum+$output[$x];
//            $count++;
//         }
//       }
//       // echo round(array_sum($output)/count($output));
//       return round($sum/1000);
//       // var_dump($output);
// }
  // include("getid3/getid3.php");
  // $getID3cut = new getID3;
  //   function getWaveform($sample_rate, $playtime, $filePath)
  //   {
  //   // echo $filePath;
  //     $filePath=escapeshellarg($filePath);//str_replace(" ", "\ ", $filePath);
  //     //error_log($filePath);
  //     $sample_per_second=2;//round($playtime/(1000000/$sample_rate));
  //     //echo '  '.$sample_per_second;
  //     $points = $sample_rate*$playtime;
  //     exec('/usr/local/bin/audiowaveform -i '.$filePath.' -o /Users/macbook/Dropbox/sample.json -z '.$sample_per_second.' --background-color ffffff --waveform-color EF8800  --no-axis-labels -w '.$points.' -h 15 ', $output, $return_var);
  //     echo '/usr/local/bin/audiowaveform -i '.$filePath.' -o /Users/macbook/Dropbox/sample.json -z '.$sample_per_second.' --background-color ffffff --waveform-color EF8800  --no-axis-labels -w '.$points.' -h 15 ';
  //     // exec('/usr/local/bin/audiowaveform -i '.$filePath.' -o /Users/macbook/Dropbox/sample.png -z '.$sample_per_second.' --background-color ffffff00 --waveform-color EF8800  --no-axis-labels -w 30000 -h 15', $output, $return_var);

  //   }
  //     $mp3file=new MP3_data(); 
  //   $mp3file->getid3($filename);
  //   $getID3 = new getID3; 
    //$filePath = "/Applications/MAMP/htdocs/store/Знакводолея.mp3"; 
  //   $ThisFileInfo = $getID3->analyze($targetFile); 

  //   // getCover($upload_directory_url.$name, $img);
  //   $len= @$ThisFileInfo['playtime_string']; // echo @$ThisFileInfo['audio']['sample_rate'];//print_r(@$ThisFileInfo);
  //   $split = explode(':', $len);
  //   $seconds=(($split[0]*60)+$split[1]); //echo "playtime ".$seconds;
  //   getWaveform(@$ThisFileInfo['audio']['sample_rate'], $seconds, $targetFile);
    // $filePath="/Users/macbook/Dropbox/sample.json";
  //     exec('/Users/macbook/xcode/analyzeTempo/analyzeTempo/built/volumeAverage/usr/local/bin/volumeAverage '.$filePath.'', $output, $return_var);
  //   echo $output[0];
  //   // $file=file_get_contents('/Users/macbook/Dropbox/sample.json');
  //   // $json=json_decode($file);
  //   // for ($i=0; $i < count($json->data); $i++) 
  //   // { 
  //   //   $json->data[$i]=abs($json->data[$i]);
  //   // }
  //   // var_dump($json->data);
  //   // $averageVolume=round(array_sum($json->data)/count($json->data));
  //   // echo $averageVolume;
  //   // echo "  ".count($json->data);
   // createThumb( "100001430183965/artwork/02 My Kind Of Love.mp3.jpg", "100001430183965/artwork/thumb/", 80 );   
   // exec('sox/sox '.escapeshellarg($filePath).' -n stat 2>&1 1> /dev/null', $output, $return_var);
   // $outputTempSplit = explode(': ', $output[6]);
   //             echo $outputTempSplit[1]*1000000;
// error_log($_GET['key']);
// exec('/usr/local/bin/exiftool /Applications/MAMP/htdocs/store/Знакводолея.mp3',$output, $return_var);
// $outputEnd =  str_replace('Artist                          : ', '', $output[25]);
// $outputEnd1= str_replace('Title                           : ', '', $output[24]);
// error_log($outputEnd);
// error_log($outputEnd1);
class WebsocketServer
{
    public function __construct($config) {
        $this->config = $config;
    }

    public function start() {
        //открываем серверный сокет
        $server = stream_socket_server("tcp://{$this->config['host']}:{$this->config['port']}", $errorNumber, $errorString);

        if (!$server) {
            die("error: stream_socket_server: $errorString ($errorNumber)\r\n");
        }

        list($pid, $master, $workers) = $this->spawnWorkers();//создаём дочерние процессы

        if ($pid) {//мастер
            fclose($server);//мастер не будет обрабатывать входящие соединения на основном сокете
            $WebsocketMaster = new WebsocketMaster($workers);//мастер будет пересылать сообщения между воркерами
            $WebsocketMaster->start();
        } else {//воркер
            $WebsocketHandler = new WebsocketHandler($server, $master);
            $WebsocketHandler->start();
        }
    }

    protected function spawnWorkers() {
        $master = null;
        $workers = array();
        $i = 0;
        while ($i < $this->config['workers']) {
            $i++;
            //создаём парные сокеты, через них будут связываться мастер и воркер
            $pair = stream_socket_pair(STREAM_PF_UNIX, STREAM_SOCK_STREAM, STREAM_IPPROTO_IP);

            $pid = pcntl_fork();//создаём форк
            if ($pid == -1) {
                die("error: pcntl_fork\r\n");
            } elseif ($pid) { //мастер
                fclose($pair[0]);
                $workers[$pid] = $pair[1];//один из пары будет в мастере
            } else { //воркер
                fclose($pair[1]);
                $master = $pair[0];//второй в воркере
                break;
            }
        }

        return array($pid, $master, $workers);
    }
}

class WebsocketMaster
{
    protected $workers = array();
    protected $clients = array();

    public function __construct($workers) {
        $this->clients = $this->workers = $workers;
    }

    public function start() {
        while (true) {
            //подготавливаем массив всех сокетов, которые нужно обработать
            $read = $this->clients;

            stream_select($read, $write, $except, null);//обновляем массив сокетов, которые можно обработать

            if ($read) {//пришли данные от подключенных клиентов
                foreach ($read as $client) {
                    $data = fread($client, 1000);

                    if (!$data) { //соединение было закрыто
                        unset($this->clients[intval($client)]);
                        @fclose($client);
                        continue;
                    }

                    foreach ($this->workers as $worker) {//пересылаем данные во все воркеры
                        if ($worker !== $client) {
                            fwrite($worker, $data);
                        }
                    }
                }
            }
        }
    }
}

abstract class WebsocketWorker
{
    protected $clients = array();
    protected $server;
    protected $master;
    protected $pid;
    protected $handshakes = array();
    protected $ips = array();

    public function __construct($server, $master) {
        $this->server = $server;
        $this->master = $master;
        $this->pid = posix_getpid();
    }

    public function start() {
        while (true) {
            //подготавливаем массив всех сокетов, которые нужно обработать
            $read = $this->clients;
            $read[] = $this->server;
            $read[] = $this->master;

            $write = array();
            if ($this->handshakes) {
                foreach ($this->handshakes as $clientId => $clientInfo) {
                    if ($clientInfo) {
                        $write[] = $this->clients[$clientId];
                    }
                }
            }

            stream_select($read, $write, $except, null);//обновляем массив сокетов, которые можно обработать

            if (in_array($this->server, $read)) { //на серверный сокет пришёл запрос от нового клиента
                //подключаемся к нему и делаем рукопожатие, согласно протоколу вебсокета
                if ($client = stream_socket_accept($this->server, -1)) {
                    $address = explode(':', stream_socket_get_name($client, true));
                    if (isset($this->ips[$address[0]]) && $this->ips[$address[0]] > 5) {//блокируем более пяти соединий с одного ip
                        @fclose($client);
                    } else {
                        @$this->ips[$address[0]]++;

                        $this->clients[intval($client)] = $client;
                        $this->handshakes[intval($client)] = array();//отмечаем, что нужно сделать рукопожатие
                    }
                }

                //удаляем сервеный сокет из массива, чтобы не обработать его в этом цикле ещё раз
                unset($read[array_search($this->server, $read)]);
            }

            if (in_array($this->master, $read)) { //пришли данные от мастера
                $data = fread($this->master, 1000);

                $this->onSend($data);//вызываем пользовательский сценарий

                //удаляем мастера из массива, чтобы не обработать его в этом цикле ещё раз
                unset($read[array_search($this->master, $read)]);
            }

            if ($read) {//пришли данные от подключенных клиентов
                foreach ($read as $client) {
                    if (isset($this->handshakes[intval($client)])) {
                        if ($this->handshakes[intval($client)]) {//если уже было получено рукопожатие от клиента
                            continue;//то до отправки ответа от сервера читать здесь пока ничего не надо
                        }

                        if (!$this->handshake($client)) {
                            unset($this->clients[intval($client)]);
                            unset($this->handshakes[intval($client)]);
                            $address = explode(':', stream_socket_get_name($client, true));
                            if (isset($this->ips[$address[0]]) && $this->ips[$address[0]] > 0) {
                                @$this->ips[$address[0]]--;
                            }
                            @fclose($client);
                        }
                    } else {
                        $data = fread($client, 1000);

                        if (!$data) { //соединение было закрыто
                            unset($this->clients[intval($client)]);
                            unset($this->handshakes[intval($client)]);
                            $address = explode(':', stream_socket_get_name($client, true));
                            if (isset($this->ips[$address[0]]) && $this->ips[$address[0]] > 0) {
                                @$this->ips[$address[0]]--;
                            }
                            @fclose($client);
                            $this->onClose($client);//вызываем пользовательский сценарий
                            continue;
                        }

                        $this->onMessage($client, $data);//вызываем пользовательский сценарий
                    }
                }
            }

            if ($write) {
                foreach ($write as $client) {
                    if (!$this->handshakes[intval($client)]) {//если ещё не было получено рукопожатие от клиента
                        continue;//то отвечать ему рукопожатием ещё рано
                    }
                    $info = $this->handshake($client);
                    $this->onOpen($client, $info);//вызываем пользовательский сценарий
                }
            }
        }
    }

    protected function handshake($client) {
        $key = $this->handshakes[intval($client)];

        if (!$key) {
            //считываем загаловки из соединения
            $headers = fread($client, 10000);
            preg_match("/Sec-WebSocket-Key: (.*)\r\n/", $headers, $match);

            if (empty($match[1])) {
                return false;
            }

            $key = $match[1];

            $this->handshakes[intval($client)] = $key;
        } else {
            //отправляем заголовок согласно протоколу вебсокета
            $SecWebSocketAccept = base64_encode(pack('H*', sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
            $upgrade = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
                "Upgrade: websocket\r\n" .
                "Connection: Upgrade\r\n" .
                "Sec-WebSocket-Accept:$SecWebSocketAccept\r\n\r\n";
            fwrite($client, $upgrade);
            unset($this->handshakes[intval($client)]);
        }

        return $key;
    }

    protected function encode($payload, $type = 'text', $masked = false)
    {
        $frameHead = array();
        $payloadLength = strlen($payload);

        switch ($type) {
            case 'text':
                // first byte indicates FIN, Text-Frame (10000001):
                $frameHead[0] = 129;
                break;

            case 'close':
                // first byte indicates FIN, Close Frame(10001000):
                $frameHead[0] = 136;
                break;

            case 'ping':
                // first byte indicates FIN, Ping frame (10001001):
                $frameHead[0] = 137;
                break;

            case 'pong':
                // first byte indicates FIN, Pong frame (10001010):
                $frameHead[0] = 138;
                break;
        }

        // set mask and payload length (using 1, 3 or 9 bytes)
        if ($payloadLength > 65535) {
            $payloadLengthBin = str_split(sprintf('%064b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 255 : 127;
            for ($i = 0; $i < 8; $i++) {
                $frameHead[$i + 2] = bindec($payloadLengthBin[$i]);
            }
            // most significant bit MUST be 0
            if ($frameHead[2] > 127) {
                return array('type' => '', 'payload' => '', 'error' => 'frame too large (1004)');
            }
        } elseif ($payloadLength > 125) {
            $payloadLengthBin = str_split(sprintf('%016b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 254 : 126;
            $frameHead[2] = bindec($payloadLengthBin[0]);
            $frameHead[3] = bindec($payloadLengthBin[1]);
        } else {
            $frameHead[1] = ($masked === true) ? $payloadLength + 128 : $payloadLength;
        }

        // convert frame-head to string:
        foreach (array_keys($frameHead) as $i) {
            $frameHead[$i] = chr($frameHead[$i]);
        }
        if ($masked === true) {
            // generate a random mask:
            $mask = array();
            for ($i = 0; $i < 4; $i++) {
                $mask[$i] = chr(rand(0, 255));
            }

            $frameHead = array_merge($frameHead, $mask);
        }
        $frame = implode('', $frameHead);

        // append payload to frame:
        for ($i = 0; $i < $payloadLength; $i++) {
            $frame .= ($masked === true) ? $payload[$i] ^ $mask[$i % 4] : $payload[$i];
        }

        return $frame;
    }

    protected function decode($data)
    {
        $unmaskedPayload = '';
        $decodedData = array();

        // estimate frame type:
        $firstByteBinary = sprintf('%08b', ord($data[0]));
        $secondByteBinary = sprintf('%08b', ord($data[1]));
        $opcode = bindec(substr($firstByteBinary, 4, 4));
        $isMasked = ($secondByteBinary[0] == '1') ? true : false;
        $payloadLength = ord($data[1]) & 127;

        // unmasked frame is received:
        if (!$isMasked) {
            return array('type' => '', 'payload' => '', 'error' => 'protocol error (1002)');
        }

        switch ($opcode) {
            // text frame:
            case 1:
                $decodedData['type'] = 'text';
                break;

            case 2:
                $decodedData['type'] = 'binary';
                break;

            // connection close frame:
            case 8:
                $decodedData['type'] = 'close';
                break;

            // ping frame:
            case 9:
                $decodedData['type'] = 'ping';
                break;

            // pong frame:
            case 10:
                $decodedData['type'] = 'pong';
                break;

            default:
                return array('type' => '', 'payload' => '', 'error' => 'unknown opcode (1003)');
        }

        if ($payloadLength === 126) {
            $mask = substr($data, 4, 4);
            $payloadOffset = 8;
            $dataLength = bindec(sprintf('%08b', ord($data[2])) . sprintf('%08b', ord($data[3]))) + $payloadOffset;
        } elseif ($payloadLength === 127) {
            $mask = substr($data, 10, 4);
            $payloadOffset = 14;
            $tmp = '';
            for ($i = 0; $i < 8; $i++) {
                $tmp .= sprintf('%08b', ord($data[$i + 2]));
            }
            $dataLength = bindec($tmp) + $payloadOffset;
            unset($tmp);
        } else {
            $mask = substr($data, 2, 4);
            $payloadOffset = 6;
            $dataLength = $payloadLength + $payloadOffset;
        }

        /**
         * We have to check for large frames here. socket_recv cuts at 1024 bytes
         * so if websocket-frame is > 1024 bytes we have to wait until whole
         * data is transferd.
         */
        if (strlen($data) < $dataLength) {
            return false;
        }

        if ($isMasked) {
            for ($i = $payloadOffset; $i < $dataLength; $i++) {
                $j = $i - $payloadOffset;
                if (isset($data[$i])) {
                    $unmaskedPayload .= $data[$i] ^ $mask[$j % 4];
                }
            }
            $decodedData['payload'] = $unmaskedPayload;
        } else {
            $payloadOffset = $payloadOffset - 4;
            $decodedData['payload'] = substr($data, $payloadOffset);
        }

        return $decodedData;
    }

    abstract protected function onOpen($client, $info);

    abstract protected function onClose($client);

    abstract protected function onMessage($client, $data);

    abstract protected function onSend($data);

    abstract protected function send($data);
}

//пример реализации чата
class WebsocketHandler extends WebsocketWorker
{
    protected function onOpen($client, $info) {//вызывается при соединении с новым клиентом

    }

    protected function onClose($client) {//вызывается при закрытии соединения клиентом

    }

    protected function onMessage($client, $data) {//вызывается при получении сообщения от клиента
        $data = $this->decode($data);

        if (!$data['payload']) {
            return;
        }

        if (!mb_check_encoding($data['payload'], 'utf-8')) {
            return;
        }
        //var_export($data);
        //шлем всем сообщение, о том, что пишет один из клиентов
        $message = 'пользователь #' . intval($client) . ' (' . $this->pid . '): ' . strip_tags($data['payload']);
        $this->send($message);

        $this->sendHelper($message);
    }

    protected function onSend($data) {//вызывается при получении сообщения от мастера
        $this->sendHelper($data);
    }

    protected function send($message) {//отправляем сообщение на мастер, чтобы он разослал его на все воркеры
        @fwrite($this->master, $message);
    }

    private function sendHelper($data) {
        $data = $this->encode($data);

        $write = $this->clients;
        if (stream_select($read, $write, $except, 0)) {
            foreach ($write as $client) {
                @fwrite($client, $data);
            }
        }
    }
}

$config = array(
    'host' => 'localhost',
    'port' => 7001,
    'workers' => 1,
);

$WebsocketServer = new WebsocketServer($config);
$WebsocketServer->start();
?>