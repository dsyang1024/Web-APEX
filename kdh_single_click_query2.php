<form method=post name=f1 action='' align=center>
  <input type=hidden name=todo value=submit>
  <table border="1" cellpadding="0" height ="80%" width="100%" >
    <tr> <!--입력자료 구성부 시작-->
      <td  align=center  >
        연도(yyyy): <input type=text id="year" name=year size=4 value=2010 style="width:80px;height:30px">

        월: <select id="month" name=month style="width:80px;height:30px">
          <option value='01'>월 선택</option>
          <option value='01'>1월</option>
          <option value='02'>2월</option>
          <option value='03'>3월</option>
          <option value='04'>4월</option>
          <option value='05'>5월</option>
          <option value='06'>6월</option>
          <option value='07'>7월</option>
          <option value='08'>8월</option>
          <option value='09'>9월</option>
          <option value='10'>10월</option>
          <option value='11'>11월</option>
          <option value='12'>12월</option>
        </select>
          
        일: <select id="day" name=day style="width:80px;height:30px">
          <option value='01'>일자 선택</option>
          <option value='01'>01</option>
          <option value='02'>02</option>
          <option value='03'>03</option>
          <option value='04'>04</option>
          <option value='05'>05</option>
          <option value='06'>06</option>
          <option value='07'>07</option>
          <option value='08'>08</option>
          <option value='09'>09</option>
          <option value='10'>10</option>
          <option value='11'>11</option>
          <option value='12'>12</option>
          <option value='13'>13</option>
          <option value='14'>14</option>
          <option value='15'>15</option>
          <option value='16'>16</option>
          <option value='17'>17</option>
          <option value='18'>18</option>
          <option value='19'>19</option>
          <option value='20'>20</option>
          <option value='21'>21</option>
          <option value='22'>22</option>
          <option value='23'>23</option>
          <option value='24'>24</option>
          <option value='25'>25</option>
          <option value='26'>26</option>
          <option value='27'>27</option>
          <option value='28'>28</option>
          <option value='29'>29</option>
          <option value='30'>30</option>
          <option value='31'>31</option>
        </select>
        모의기간: <input type=text id="dur" name=dur size=3 value=5 style="width:80px;height:30px">년<br/>
        <br/>
        <input type=submit id="Submit" name="Submit" value="APEX 입력자료 구축" style="height:30px; width:200px;" onclick = 'alert("APEX 입력자료 구축 완료")'/>
        <p style = "font-size:11px;">*일자를 미기입시 자동적으로 1월 1일부터 모의가 시작됩니다.</p>
      </td>
    </tr> <!--입력자료 구성부 종료-->

    <tr><!--최적관리기법 적용부 시작-->
      <td  align=center  > 
        최적관리기법(BMPs) 적용 버튼
        <br/>
        <form method="post">
          <input type='submit' id="grassed_waterway" name="grassed_waterway" value='식생수로'
            onclick='alert("BMP 적용 완료")'/>
                
          <input type='button' 
            value='계단식 밭' 
            onclick='alert("안녕하세요")'/>
                
          <input type='button' 
            value='초생대' 
            onclick='alert("안녕하세요")'/>
                
          <input type='button' 
            value='우회수로' 
            onclick='alert("안녕하세요")'/>
                
          <input type='button' 
            value='경사저감시설' 
            onclick='alert("안녕하세요")'/>
          <br/><br/>
          <input type='button' 
            value='비료 50% 줄이기' 
            onclick='alert("안녕하세요")'/>
                
          <input type='button' 
            value='비료 70% 줄이기' 
            onclick='alert("안녕하세요")'/>
                
          <input type='button' 
            value='무경운' 
            onclick='alert("안녕하세요")'/>
        </form>
      </td>
    </tr><!--최적관리기법 적용부 시작-->
  </table>
  <br/>
  <input type='submit' id="run_apex" name="run_apex" value='APEX 모의 실행' style="height:30px; width:200px;"
    onclick='alert("APEX 모의가 진행 중입니다.");document.getElementById('check_result').disabled=false;'/>
  <input type='submit' id="check_result" name="check_result" value='모의결과 확인' style="height:30px; width:200px;"/>
</form>  

<!--
<script>
var button = document.getElementById("check_result");
var clickBtn = document.getElementById("run_apex");

// Disable the button on initial page load
button.disabled = true;

$('run_apex').on('click', function (e) {
    e.preventDefault();
    $('f1').find('check_result').prop('disabled', false);
});
</script>
-->

<?php
  error_reporting(0);
  //--모의 기간 정보--//
  $year = $_POST['year'];
  $month = $_POST['month'];
  $day = $_POST['day'];
  $dur = $_POST['dur'];  
  //--경작지 정보--//
  $elevation = $_GET['elevation'];
  $area_1 = $_GET['area_1'];
  $slope = $_GET['slope'];
  $slength = $_GET['slength'];
  $soil_code = $_GET['soil_code'];
  $coord_x = $_GET['coord_x'];
  $coord_y = $_GET['coord_y'];
  $number1 = $_GET['number1'];
  $num = $_GET['num'];
  
  $ip_address = $_SERVER["REMOTE_ADDR"];

  mkdir("input_folder/$ip_address",true);

  /* 페이지 내에 입력변수 확인하기
    echo
    'IP : ',$ip_address,'<br/>',
    '일자 : ',$year,'-',$month,'-',$day,'<br/>',
    '모의기간 : ',$dur,' 년<br/>',
    '고도 : ',$elevation,' m<br/>',
    '면적 : ',round($area_1/10000,2),' ha<br/>',
    '경사도 : ',round($slope/100,2),' m/m<br/>',
    '위도 : ',round($coord_y,4),' degree<br/>',
    '경도 : ',round($coord_x,4),' degree<br/>',
    '기상 관측소 번호 : ',$number1,'<br/><br/>';
  */
  if(isset($_POST['Submit'])){
    exec("C:/Python/python C:/inetpub/wwwroot/APEX/input.py $elevation $area_1 $slope $slength $soil_code $coord_x $coord_y $number1 $num $year $month $day $dur $ip_address");
    };/*APEX 입력자료 구축 python 스크립트 실행*/

  if(isset($_POST['grassed_waterway'])){
    exec("C:/Python/python C:/inetpub/wwwroot/APEX/bmp_scripts/grassed_waterway.py $ip_address");
  };/*식생수로 적용 python 스크립트 실행*/

  if(isset($_POST['run_apex'])){
    exec("C:/Python/python C:/inetpub/wwwroot/APEX/run_apex.py $ip_address");
    echo("<script>location.replace('result_chart.php');</script>");
  };/*식생수로 적용 python 스크립트 실행*/


  /*
  이 부분에 APEX를 실행하고 결과를 가져오는 파일을 만든다.
  */

?>