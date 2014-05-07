php-pagination
==============

A Simple pagination Script in PHP


This script will generate pagination.

Two step integration
========================
1)include that pagination.php file

2)Paste following lines of codes where you wanted to show the pagination.

Note:Needed to pass the value of totalItems and if you wanted to preserve the name of other getVariable then define them here

//pagination(prevnext,totalItem,perPageItemLimit,getParamterArray,getVariable for pageno
$pagination=new pagination("2","100","10",array("reportname"),"pageno");

echo $pagination->finalPagination;


