<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <style type="text/css">

        body {
            overflow: auto;
            text-align: left;
            white-space: normal;
            word-break: break-all;
            margin: 0;
            padding: 0;
            background-color: rgb(128, 128, 128);
            font-size: 10.5pt;
        }

        #content {
            <?php if($pic){
                echo 'width: 100%;';
            }else{
                echo 'width: 756px;';
            } ?>
            height: 100%;
            background:#fff;
            padding:0 20px;
            margin:0 auto;
        }
        .pageBreak{
            page-break-after:always;
        }
        #printButton input{
            position: fixed;
            top:10px;
            right:10px;
        }
    </style>

    <style type="text/css" media=print >
        #printButton{
            display: none;
        }
    </style>

</head>


<body>
<div id="main">
    <div id="printButton">
        <input type="button" value="打印" onclick="window.print();"/>
    </div>
    <div id="content">
        <?php echo $content; ?>
    </div>
</div>
</body>
</html>