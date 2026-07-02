<?
$strings = [
    'ZGVmaW5l', 'c3RycmV2', 'c3RydG91cHBlcg==', 'aXNfZGly', 
    'b3BlbmRpcg==', 'cmVhZGRpcg==', 'Y2xvc2VkaXI=', 'aXNfZGly', 
    'b3BlbmRpcg==', 'cmVhZGRpcg==', 'aXNfZGly', 'b3BlbmRpcg==', 
    'cmVhZGRpcg==', 'Y2xvc2VkaXI=', 'Y2xvc2VkaXI=', 'c3RycmV2', 
    'aW1wbG9kZQ==', 'ZGF0ZQ==', 'bWt0aW1l', 'ZGF0ZQ==', 
    'ZGF0ZQ==', 'ZGF0ZQ==', 'ZGF0ZQ==', 'bWt0aW1l', 'ZGF0ZQ==', 
    'ZGF0ZQ==', 'ZGF0ZQ==', 'ZGF0ZQ==', 'bWt0aW1l', 'ZGF0ZQ==', 
    'ZGF0ZQ==', 'ZGF0ZQ==', 'c3Vic3Ry', 'c3Vic3Ry', 'c3Vic3Ry', 
    'c3Vic3Ry', 'c3Vic3Ry', 'c3Vic3Ry', 'c3Vic3Ry', 'c3Vic3Ry', 
    'c3RycmV2', 'c3ByaW50Zg==', 'c3RybGVu', 'c3RybGVu', 'Y2hy', 
    'b3Jk', 'b3Jk', 'YmFzZTY0X2VuY29kZQ==', 'ZmlsZV9leGlzdHM=', 
    'Zm9wZW4=', 'ZndyaXRl', 'ZmNsb3Nl', 'c3ByaW50Zg==', 
    'c3Vic3Ry', 'c3RycmV2', 'ZGF0ZQ==', 'bWt0aW1l', 'ZGF0ZQ==', 
    'ZGF0ZQ==', 'ZGF0ZQ==', 'ZGF0ZQ==', 'bWt0aW1l', 'ZGF0ZQ==', 
    'ZGF0ZQ==', 'ZGF0ZQ==', 'ZGF0ZQ==', 'bWt0aW1l', 'ZGF0ZQ==', 
    'ZGF0ZQ==', 'ZGF0ZQ==', 'c3Vic3Ry', 'c3Vic3Ry', 'c3Vic3Ry', 
    'c3Vic3Ry', 'c3Vic3Ry', 'c3Vic3Ry', 'c3Vic3Ry', 'c3Vic3Ry', 
    'c3RycmV2', 'c3RybGVu', 'c3RybGVu', 'Y2hy', 'b3Jk', 'b3Jk', 
    'c3ByaW50Zg==', 'c3Vic3Ry', 'c3RycmV2', 'YmFzZTY0X2VuY29kZQ==', 
    'aXNfb2JqZWN0', 'c3RydG9sb3dlcg==', 'c3RydG9sb3dlcg==', 
    'aXNfZGly', 'YXJyYXlfZGlmZg==', 'c2NhbmRpcg==', 
    'cmVhbHBhdGg=', 'cm1kaXI=', 'aXNfZmlsZQ==', 'dW5saW5r'
];


foreach ($strings as $encoded) {
    echo base64_decode($encoded) . PHP_EOL;
}