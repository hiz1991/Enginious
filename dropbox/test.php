<?php

# Include the Dropbox SDK libraries
require_once "lib/Dropbox/autoload.php";
use \Dropbox as dbx;

$appInfo = dbx\AppInfo::loadFromJsonFile("json.json");
$webAuth = new dbx\WebAuthNoRedirect($appInfo, "PHP-Example/1.0");

$authorizeUrl = $webAuth->start();

echo "1. Go to: " . $authorizeUrl . "\n";
echo "2. Click \"Allow\" (you might have to log in first).\n";
echo "3. Copy the authorization code.\n";
$authCode = "Ooegl2bEsf8AAAAAAAB9EsV9zTWAaadFM8th4PA5RrM";//\trim(\readline("Enter the authorization code here: "));

list($accessToken, $dropboxUserId) = $webAuth->finish($authCode);
print "Access Token: " . $accessToken . "\n";

$dbxClient = new dbx\Client($accessToken, "17102650");
$accountInfo = $dbxClient->getAccountInfo();

print_r($accountInfo);

// $f = fopen("working-draft.txt", "rb");
// $result = $dbxClient->uploadFile("/working-draft.txt", dbx\WriteMode::add(), $f);
// fclose($f);
// print_r($result);

$folderMetadata = $dbxClient->getMetadataWithChildren("/");
echo json_encode($folderMetadata);

// $f = fopen("working-draft.txt", "w+b");
// $fileMetadata = $dbxClient->getFile("/working-draft.txt", $f);
// fclose($f);
// print_r($fileMetadata);