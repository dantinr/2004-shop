<script src="/js/jquery-3.5.1.min.js"></script>

商品ID： {{ $g['goods_id'] }} <br>
商品名： {{ $g['goods_name'] }} <br>
商品价格： {{ $g->shop_price }}

<hr>

<button id="btn_add">加入购物车</button>

<script>
    $("#btn_add").click(function(){

        $.ajax({
            url: "/cart/add?id="+{{ $g['goods_id'] }},
            type: "get",
            dataType: "json",
            success: function(d){

                if(d.errno==0)
                {
                    alert(d.msg)
                }else{

                    if(d.errno==400001)
                    {
                        alert(d.msg);
                        window.location.href = '/user/login';
                    }

                }
            }
        })
    });

</script>
