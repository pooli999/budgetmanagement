<?php
include("config.php");
include("helper.php");
include("data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => getMenuItem(lurl::dotPage($startupPage))->MenuName,
		'link' => '?mod='.lurl::dotPage($startupPage)
	),
	array(
		'text' => $MenuName,
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'รายละเอียด',
	),
));

?>
<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
  </tr>
</table>
<div id='detail' style="display:<?php echo ''?>">
  <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
    <tr>
      <th width="150" height="25">ปีงบประมาณ :</th>
      <td width="8">&nbsp;</td>
      <td>2554</td>
    </tr>
    <tr>
      <th height="25">ชื่อแผนงาน :</th>
      <td>&nbsp;</td>
      <td>แผนงานภาคีเครือข่ายภาคใต้</td>
    </tr>
    <tr>
      <th height="25">ชื่อกิจกรรมหลัก :</th>
      <td>&nbsp;</td>
      <td>สร้างความสามัคคีร่วมกับภาคประชาชนภาคใต้โดยราชการ</td>
    </tr>
    <tr>
      <th height="25">ชื่อโครงการ :</th>
      <td>&nbsp;</td>
      <td>ร่วมรณรงค์อบรมการมีส่วนร่วม ความสามัคคีทุกภาคส่วน</td>
    </tr>
    <tr>
      <th>ระยะดำเนินโครงการ :</th>
      <td><span class="require"></span></td>
      <td>05 พ.ค. 54 ถึง 30 ต.ค. 54</td>
    </tr>
    <tr>
      <th  style="vertical-align:top">สำนักอง :</th>
      <td>&nbsp;</td>
      <td><table width="100%" border="0" class="tbl-view">
        <tr>
          <th  style="width:15px">ลำดับ</th>
          <th style="width:100%">สำนัก / กอง</th>
        </tr>
        <tr>
          <td align="center">1.</td>
          <td>สำนักธรรมนูญสุขภาพและนโยบาย</td>
        </tr>
        <tr>
          <td align="center">2.</td>
          <td>สำนักสมัชชาสุขภาพ</td>
        </tr>
        <tr>
          <td align="center">3.</td>
          <td>สำนักอำนวยการ</td>
        </tr>
        <tr>
          <td align="center">4.</td>
          <td>สำนักสนับสนุนการจำดการเครือข่าย</td>
        </tr>
        <tr>
          <td align="center">5.</td>
          <td>สำนักยุทธศาสตร์แผนการประเมิลผล</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <th style="vertical-align:top">ผู้รับผิดชอบ :</th>
      <td>&nbsp;</td>
      <td><table width="100%" border="0" class="tbl-view">
        <tr>
          <th  style="width:15px">ลำดับ</th>
          <th style="width:30%">สำนัก / กอง</th>
          <th style="width:70%">รายชือบุคลากร</th>
        </tr>
        <tr>
          <td align="center">1.</td>
          <td>สำนักธรรมนูญสุขภาพและนโยบาย</td>
          <td>1. บุษบากร เวทยไวยกูณฐ์</td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          <td>2. วิทยา เยาวพงษ์</td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          <td>3. ขวัญแก้ว เท้าจันทร์</td>
        </tr>
        <tr>
          <td align="center">2.</td>
          <td>สำนักอำนวยการ</td>
          <td>1. ณรงค์ เสประโคน</td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          <td>2. ชูชัย องค์อางชัย</td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          <td>3. วรพล วงศ์เสวกจัทร์</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <th>หมายแลขโทรศัพท์:</th>
      <td>&nbsp;</td>
      <td>0271874100</td>
    </tr>
    <tr>
      <th valign="top">โทรสาร :</th>
      <td valign="top"><span class="require"></span></td>
      <td>027187500</td>
    </tr>
    <tr>
      <th>อีเมลล์:</th>
      <td></td>
      <td>info@mationalhealth.go.th</td>
    </tr>
    <tr>
      <th>หลักการณ์เหตุผล :</th>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th>วัตถุประสงค์โครงการ :</th>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <div style="margin-bottom:20px; margin-top:10px">
    <fieldset>
      <legend><b>ไฟล์โครงการเอกสาร</b></legend>
      <table width="100%" border="0" class="tbl-view">
        <tr>
          <th  style="width:15px">ลำดับ</th>
          <th style="width:30%">เอกสารแนบ</th>
          <th style="width:70%">คำอธิบายเอกสารแนบ</th>
        </tr>
        <tr>
          <td class="center">1.</td>
          <td><a href="" class="ico xls">Progress.xls</a></td>
          <td>ไฟล์แผนความก้าวหน้า</td>
        </tr>
        <tr>
          <td align="center">2.</td>
          <td><a href="" class="ico doc">Plan1.doc</a></td>
          <td>ไฟล์แผนงานโครงการ 2011 0505</td>
        </tr>
        <tr>
          <td align="center">3.</td>
          <td><a href="" class="ico pdf">plan2.pdf</a></td>
          <td>ไฟล์แผนงานโครงการ 2011 05099</td>
        </tr>
      </table>
    </fieldset>
  </div>
  <div>
    <fieldset>
      <legend><b>ขั้นตอนการดำเนินงาน</b></legend>
      <table width="100%" border="0" class="tbl-view">
        <tr>
          <th  style="width:150px">วันเริ่มต้นกิจกรรม</th>
          <th style="width:150px">วันสิ้นสุดกิจกรรม</th>
          <th style="width:35%">รายการกิจกรรม</th>
          <th style="width:35%">สำนัก/กอง ปฏิบัติงาน</th>
        </tr>
        <tr>
          <td class="center">05 พ.ค. 54</td>
          <td>10 พ.ค. 54</td>
          <td>ประชุมวางแผนกิจกรรม</td>
          <td>สสช.</td>
        </tr>
        <tr>
          <td align="center">13 พ.ค. 54</td>
          <td>30 ม.ค. 54</td>
          <td>นำเสนอแผนงาน</td>
          <td>สสช.</td>
        </tr>
        <tr>
          <td align="center">1 ก.ย. 54</td>
          <td>15 ก.ย. 54</td>
          <td>ประชุมร่วมกับภาคีเครือข่าย</td>
          <td>คปก.</td>
        </tr>
      </table>
    </fieldset>
  </div>
</div>
