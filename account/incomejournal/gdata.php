    <?php  
    header("Content-type:text/html; charset=UTF-8");          
    header("Cache-Control: no-store, no-cache, must-revalidate");         
    header("Cache-Control: post-check=0, pre-check=0", false);         
    // เชื่อมต่อฐานข้อมูล  
    $link=mysql_connect("localhost","root1","1234") or die("error".mysql_error());  
    mysql_select_db("nationalhealth",$link);  
    mysql_query("set character set utf8");  
       
    $q = urldecode($_GET["q"]);  
    $pagesize = 50; // จำนวนรายการที่ต้องการแสดง  
    $table_db="ac_chart"; // ตารางที่ต้องการค้นหา  
    $find_field="AcChartCode"; // ฟิลที่ต้องการค้นหา  
    $sql = "select * from $table_db ";  
    $results = mysql_query($sql);
    while ($row = mysql_fetch_array( $results )) { 
        $id = $row["AcChartCode"]; // ฟิลที่ต้องการส่งค่ากลับ
        $name = ucwords( strtolower( $row["AcChartCode"] ) ); // ฟิลที่ต้องการแสดงค่า  
        // ป้องกันเครื่องหมาย '  
        $name = str_replace("'", "'", $name);  
        // กำหนดตัวหนาให้กับคำที่มีการพิมพ์  
        $display_name = preg_replace("/(" . $q . ")/i", "<b>$1</b>", $name);  
        echo "<li onselect=\"this.setText('$name').setValue('$id');\">$display_name</li>";  
    }  
    mysql_close();  
    ?>  