<?php

namespace App\Helpers;

use App\Repository\BBL\apiErpRepository;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use DB;
use View;
use PHPMailer\PHPMailer\PHPMailer;

class MailManager
{

  public static function mailFail($xml, $order_code, $configuation)
  {
    $mail_data = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
    $mail_data .= "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
    $mail_data .= "<head>";
    $mail_data .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
    $mail_data .= "</head>";
    $mail_data .= "<body style=\"font-family:arial;word-wrap:break-word;\">";
    $mail_data .= "<div class=\"container\" style=\"width:768px;margin-right:auto;margin-left:auto;padding:15px;\">";
    $mail_data .= "<table><tbody><tr><td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top: 1px solid #e7ecf1;\"><a title=\"Thai Travel Center\"><img style=\"border:none;\" src=\"https://www.thaitravelcenter.com/reservation/template/theme/images/TTC-Logo.png\" align=\"left\"></a></td></tr></tbody></table>";
    $mail_data .= "<div class=\"booking-confirmation clearfix\" style=\"margin:15px 0;\">
        <table class=\"table\" style=\"width:100%;max-width:100%;\">
          <tr>
            <th style=\"text-align:left;\"><h4 style=\"margin-bottom:0;font-size:1em;line-height:1.25em;margin-top:5px;color:#671e75;\" class=\"main-message\">เรียน เจ้าหน้าที่ Thaitravelcenter</h4>
            <p style=\"margin-top:5px;font-weight:normal;\">รายงานผลการตรวจสอบการชำระเงินด้วยบัตรเครดิต Merchant Referenc No. $order_code<br>เนื่องจากระบบทำการตรวจสอบและพบว่าการชำระเงินด้วยบัตรเครดิตของหมายเลขการจองนี้ ไม่เป็นไปตามนโยบายของทางบริษัทฯ ในการรับชำระเงินด้วยบัตรเครดิตที่ผ่าน 3D Secure (Verified by VISA / MasterCardSecureCode) เท่านั้น<br></p></th>
          </tr>
        </table>
      </div>";
    $mail_data .= "<div>";
    $mail_data .= "<h4 style=\"margin-bottom:0;font-size:1em;line-height:1.25em;margin:15px 0;color:#671e75;\" class=\"main-message\">รายละเอียด</h4>";
    $mail_data .= "<table class=\"table\" style=\"border:none;padding:0;font-size:0.9em;max-width:100%;width:100%;\">";
    $mail_data .= "<thead><tr>
        <th style=\"padding:5px 2px 5px 3px!important;vertical-align:bottom;line-height:1.42857;\" align=\"left\" width=\"40%\"> Payment Status </th>
        <th style=\"padding:5px 2px 5px 3px!important;vertical-align:bottom;line-height:1.42857;\"> &nbsp; </th>
      </tr></thead>";

    $mail_data .= "<tbody>";
    $i = 0;
    foreach ($xml->record as $key => $value) {
      $mail_data .= "<tr style=\"border-left: 3px solid #f1c40f;background-color: #FAEAA9;\">
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\" colspan=\"2\"><strong> Record #" . (count($xml->record) - $i) . " </strong></td>
        </tr>";
      $mail_data .= "<tr>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> Order Status </td>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> <span class=\"bold\"> $value->orderStatus </span> </td>
        </tr>";
      $mail_data .= "<tr>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> Merchant Reference </td>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> $value->ref </td>
        </tr>";
      $mail_data .= "<tr>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> Payment Reference </td>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> $value->payRef </td>
        </tr>";
      $mail_data .= "<tr>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> Bank Reference Number </td>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> $value->ord </td>
        </tr>";
      switch ($value->eci) {
        case '05':
          $img_path = 'resources/assets/global/img/ok-VBV.png';
          break;
        case '02':
          $img_path = 'resources/assets/global/img/ok-MCSC.png';
          break;
        case '06':
        case '07':
          $img_path = 'resources/assets/global/img/no-VBV.png';
          break;
        case '00':
        case '01':
          $img_path = 'resources/assets/global/img/no-MCSC.png';
          break;
        default:
          $img_path = 'resources/assets/global/img/notpassed.png';
          break;
      }
      $mail_data .= "<tr>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> VbV/MCSC (ECI) </td>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> <img src=\"http://www.tours-smart.com/$img_path\" style=\"width: 100px;\" /><br>(ECI = $value->eci ) </td>
        </tr>";
      $mail_data .= "<tr>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> Payer Authentication Status </td>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> $value->payerAuth </td>
        </tr>";
      $mail_data .= "<tr>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> Card Holder Name </td>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> $value->holder </td>
        </tr>";
      $mail_data .= "<tr>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> Transaction Amount </td>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> $value->amt </td>
        </tr>";
      $mail_data .= "<tr>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> Transaction Currency </td>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> " . ($value->cur == '764' ? 'THB' : 'USD') . " </td>
        </tr>";
      $mail_data .= "<tr>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> Source IP </td>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> $value->sourceIp </td>
        </tr>";
      $mail_data .= "<tr>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> IP Country </td>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> $value->ipCountry </td>
        </tr>";
      $mail_data .= "<tr>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> Remark </td>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> " . (empty($value->remark) ? '--' : $value->remark) . " </td>
        </tr>";
      $mail_data .= "<tr>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> Settle Time </td>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> $value->settleTime </td>
        </tr>";
      $mail_data .= "<tr>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> Settle Status </td>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> $value->settle </td>
        </tr>";
      $mail_data .= "<tr>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> Transaction Time </td>
          <td style=\"padding:2px 8px!important;vertical-align:middle!important;font-size:1.0em!important;line-height:1.42857;border-top:1px solid #e7ecf1;\"> $value->txTime </td>
        </tr>";
      $i++;
    }
    $mail_data .= "</tbody>";

    $mail_data .= "</table>";
    $mail_data .= "<p>ระบบจึงดำเนินการยกเลิกการทำรายการและ Auto Reversal Payment ของรายการนี้แล้ว<br>เจ้าหน้าที่ Thaitravelcenter สามารถติดต่อลูกค้าเพื่อแนะนำช่องทางการชำระเงินอื่นๆ ของบริษัทฯ ต่อไป</p>";
    $mail_data .= "</div>";
    $mail_data .= "</body>";
    $mail_data .= "</html>";

    try {
      $mail = new PHPMailer(true);
      $mail->IsSMTP();
      $mail->ContentType = 'text/html';
      $mail->IsHTML(true);
      $mail->CharSet = "utf-8";
      $mail->Encoding = "base64";
      $mail->SMTPDebug = 0;
      $mail->SMTPAuth = true;
      $mail->Host = $configuation['MAIL_HOST'];
      $mail->Port = $configuation['MAIL_PORT'];
      $mail->Username = $configuation['MAIL_USER'];
      $mail->Password = $configuation['MAIL_PASS'];
      $mail->setFrom(
        $configuation['MAIL_FROM'],
        $configuation['MAIL_FROM_NAME']
      );
      $address = explode(',', $configuation['MAIL_AddAddress_FRAUD']);
      foreach ($address as $k => $v) {
        $mail->AddAddress($v, $v);
      }
      $bcc = explode(',', $configuation['MAIL_AddBCC_FRAUD']);
      foreach ($bcc as $k => $v) {
        $mail->AddBCC($v, $v);
      }

      $mail->Subject = $configuation['MAIL_SUBJECT_FRAUD'] . ' ' . $order_code;
      $body = $mail_data;
      $mail->MsgHTML($body);
      if ($mail->Send()) {
        return true;
      }
    } catch (\Exception $e) {
      return false;
    }
    return false;
  }
}
