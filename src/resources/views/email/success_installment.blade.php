<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://thaitravelcenter.com/downloads/bootstrap.min.css" rel=stylesheet>
  <link href="https://thaitravelcenter.com/downloads/jumbotron-narrow.css" rel=stylesheet>
  <style media="screen">
    .container {
      background: #fbfbfb;
      box-shadow: 1px 1px 5px 2px #ddd;
      max-width: 970px;
    }

    .logo {
      width: 160px;
      margin: 15px 0 0 0;
    }

    body {
      font-family: Calibri, SukhumvitReg;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <div class="container" style="width:768px;margin-right:auto;margin-left:auto;padding:15px;padding-top:0;">
    <div class="header clearfix">
      <h3 class="text-muted">
        <img src="https://www.travizgo.com/template/theme/images/TVG.png" class="logo" alt="Travizgo">
        <!-- dolgfk;ldfjglkj -->
      </h3>
    </div>
    <div class="row marketing">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <p style="color:black">เรียน <b style="color:#337ab7"> <?php echo $data["transaction"]->tr_customer_name ?> </b>
          <br><br>
          <h3> การชำระเงินของคุณสำเร็จแล้ว </h3>
          <p></p>
          <table class="table" style="color:black">
            <tbody style="color:black">
              <tr>
                <td style="width:350px;">Reference No. / หมายเลขอ้างอิง</td>
                <td><?php echo $data["transaction"]->tr_id ?></td>
              </tr>
              <tr>
                <td style="width:350px;">Service Code / รหัสบริการ</td>
                <td><?php echo $data["transaction"]->tr_service_code . "" . date("y") ?></td>
              </tr>
              <tr>
                <td style="width:350px;">Service Type / ประเภทบริการ</td>
                <td><?php echo $data["transaction"]->tr_product_detail ?></td>
              </tr>
              <tr>
                <td style="width:350px;">Total Amount / ราคารวมที่ชำระ</td>
                <td><?php echo number_format($data["transaction"]->tr_amounts, 2, '.', ',') ?> <?php echo $data["transaction"]->tr_currency ?></td>
              </tr>
              <!-- <tr>
                <td style="width:350px;">Quantity / จำนวน</td>
                <td><?php echo $data["transaction"]->tr_quantity ?></td>
              </tr> -->
              <tr>
                <td style="width:350px;">Date Time / วันที่เวลา </td>
                <td><?php echo $data["order"]->dfTxTime ?></td>
              </tr>


              <!-- <tr>
              <td style="width:350px;">Customer Name / ชื่อลูกค้า</td>
              <td> ramin </td>
            </tr> -->
              <tr>
                <td style="width:350px;">More Information / ข้อมูลเพิ่มเติม</td>
                <td><?php echo $data["transaction"]->tr_condition ?></td>
              </tr>

            </tbody>
          </table>
          <p></p>
          <p style="color:#337ab7"><br>
            กรณีที่ข้อมูลรายละเอียดของสินค้า/บริการไม่ถูกต้อง หรือ หากท่านต้องการสอบถามเพิ่มเติมเกี่ยวกับการชำระเงิน <br />
            กรุณาติดต่อแผนกบริการลูกค้า หรือเจ้าหน้าที่ที่ดูแลท่าน โทร 021719999 ได้ทุกวัน
          </p>
          <p style="color:black">
            <br><?php echo $data["eml"]->empl_fname_en . " " . $data["eml"]->empl_lname_en ?>
          </p>
          <p style="color:#337ab7"><span style="line-height: 1.42857;">Tel : 021719999<br>Fax : 021719900 </span></p>
          <p style="color:black"><span style="line-height: 1.42857;">Contact email:&nbsp;rsvn@travizgo.com</span>
          </p>
      </div>
    </div>
    <div class="footer">
      <p style="color:black">
        &copy; 2020 TRAVIZGO
      </p>
    </div>
  </div>