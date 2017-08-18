<?php


use yii\widgets\LinkPager;


?>





    <div class = " col-lg-10 col-md-10 col-sm-10 col-xs-10" >

    <table class="table " >
        <tr class="active">
            <div class="btn-group">
                <th><a href= <?php echo $first_url."user_name".$second_url ?> >User Name</a></th>
                <th><a href= <?php echo $first_url."email".$second_url ?> > Email:</a></th>
                <th><a href= <?php echo $first_url."date_time".$second_url ?> >Date time:</a></th>
                <th><a href= <?php echo $first_url."text".$second_url ?> > Text:</a></th>

                <th >

                                   </th>


            </div>
        </tr>
        <?php foreach ($messages as $message) {

            ?>


            <tr>
                <td><?= $message->user_name ?></td>
                <td><?= $message->email ?></td>
                <td><?= $message->date_time ?></td>
                <td><?= $message->text ?></td>



                <td> <a href = '<?= $url. $message->id?>'><div class = "btn btn-default" id = 'delete'>DELETE</div></a></td>

            </tr>

        <?php } ?>
    </table>


</div>


<!--        TABLE FOR EXPORT-->


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>




<div id="table_wrapper">

        <table class="table table-export"  id="list" border="1" style = 'display: none'>
            <tr class="active">
                <div class="btn-group">
                    <th><a href= <?php echo $first_url."user_name".$second_url ?> >User Name</a></th>
                    <th><a href= <?php echo $first_url."email".$second_url ?> > Email:</a></th>
                    <th><a href= <?php echo $first_url."date_time".$second_url ?> >Date time:</a></th>
                    <th><a href= <?php echo $first_url."text".$second_url ?> > Text:</a></th>




                </div>
            </tr>
            <?php foreach ($messages as $message) {

                ?>


                <tr>
                    <td><?= $message->user_name ?></td>
                    <td><?= $message->email ?></td>
                    <td><?= $message->date_time ?></td>
                    <td><?= $message->text ?></td>


                </tr>

            <?php } ?>
        </table>

</div>

        <button id="btnExport">Export to xls</button>

<?= LinkPager::widget(['pagination'=>$pagination]) ?>
        </div>


<!--                                EXPORT TABLE                   -->


<script>
$(document).ready(function() {
$("#btnExport").click(function(e) {
e.preventDefault();

//getting data from our table
var data_type = 'data:application/vnd.ms-excel';
var table_div = document.getElementById('table_wrapper');
var table_html = table_div.outerHTML.replace(/ /g, '%20');

var a = document.createElement('a');
a.href = data_type + ', ' + table_html;
a.download = 'exported_table_' + Math.floor((Math.random() * 9999999) + 1000000) + '.xls';
a.click();
});
});
</script>
