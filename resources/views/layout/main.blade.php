<!DOCTYPE html>
<html>

<head>
    @section('header')
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <title>品优购，优质！优质！</title>
    <link rel="icon" href="assets/img/favicon.ico">

    <link rel="stylesheet" type="text/css" href="css/webbase.css" />
    <link rel="stylesheet" type="text/css" href="css/pages-JD-index.css" />
    <link rel="stylesheet" type="text/css" href="css/widget-jquery.autocomplete.css" />
    <link rel="stylesheet" type="text/css" href="css/widget-cartPanelView.css" />
    @show
</head>

<body>
<!-- 头部栏位 -->
<!--页面顶部-->
@section('body')


    @show

    @section('footerjs')
        <!--侧栏面板结束-->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript">
            $(function(){
                $("#service").hover(function(){
                    $(".service").show();
                },function(){
                    $(".service").hide();
                });
                $("#shopcar").hover(function(){
                    $("#shopcarlist").show();
                },function(){
                    $("#shopcarlist").hide();
                });

            })
        </script>
        <script type="text/javascript" src="js/model/cartModel.js"></script>
        <script type="text/javascript" src="js/czFunction.js"></script>
        <script type="text/javascript" src="js/plugins/jquery.easing/jquery.easing.min.js"></script>
        <script type="text/javascript" src="js/plugins/sui/sui.min.js"></script>
        <script type="text/javascript" src="js/pages/index.js"></script>
        <script type="text/javascript" src="js/widget/cartPanelView.js"></script>
        <script type="text/javascript" src="js/widget/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="js/widget/nav.js"></script>
    @show
</body>


</html>
