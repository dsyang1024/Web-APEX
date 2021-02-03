<?
$ctp_kor_nm = $_GET["ctp"]; //시도
$sig_kor_nm = $_GET["sig"]; //시군구
$emd_kor_nm = $_GET["emd"]; //읍면동
if(!$ctp_kor_nm){$ctp_kor_nm = '강원도';}
if(!$sig_kor_nm){$sig_kor_nm = '홍천군';}
if(!$emd_kor_nm){$emd_kor_nm = '내면';}

$connection_string = 'host=203.252.82.167 port=5432 dbname=gis_db user=postgres password=welet#!%111';
$conn = pg_connect($connection_string) ;

$sql_info = "select point_x, point_y from emd_info where ctp_kor_nm = '".$ctp_kor_nm."' and sig_kor_nm = '".$sig_kor_nm."' and emd_kor_nm = '".$emd_kor_nm."'" ;
//echo $sql_info;
$result = pg_query($conn, $sql_info);
while ($row = pg_fetch_row($result)) {
  $point_x = $row[0];
  $point_y = $row[1];
}
pg_close($conn) ;

$group_name = $emd_kor_nm;
$group_center = "".$point_x.",".$point_y."";

/*
switch($group){
  case 0: // 권역 번호에 맞게 추가
    $group_name = "한반도면";
    $group_weather = "84,132"; //동네예보 XY좌표
    $group_weather_name = "내면";
    $group_center = "323561, 569505";
  break;
  case 1: //북한강A
    $group_name = "서면";
    $group_weather = "69,132"; //동네예보 XY좌표
    $group_weather_name = "가평읍";
    $group_center = "71875, 575613";
  break;
  case 2: //북한강B
    $group_name = "내면";
    $group_weather = "66,128"; //동네예보 XY좌표
    $group_weather_name = "서종면";
    $group_center = "56389, 562663";
  break;
  case 3: //남한강A
    $group_name = "남한강 수변구역-A";
    $group_forecast = "n_nam_a_forecast_output"; //예측강우 - 토양유실
    $group_predict = "n_nam_a_predict_output"; //실측강우 - 토양유실
    $group_field = "n_input_nam_a"; //필지정보
    $group_weather = "73,117"; //동네예보 XY좌표
    $group_weather_name = "앙성면";
    $group_center = "93553, 504054";
  break;
  case 4: //남한강B
    $group_name = "남한강 수변구역-B";
    $group_forecast = "n_nam_b_forecast_output"; //예측강우 - 토양유실
    $group_predict = "n_nam_b_predict_output"; //실측강우 - 토양유실
    $group_field = "n_input_nam_b"; //필지정보
    $group_weather = "69,125"; //동네예보 XY좌표
    $group_weather_name = "서종면";
    $group_center = "71564, 533545";
  break;
  case 4: //경안천
    $group_name = "경안천 수변구역";
    $group_forecast = "n_gyean_forecast_output"; //예측강우 - 토양유실
    $group_predict = "n_gyean_predict_output"; //실측강우 - 토양유실
    $group_field = "n_input_gyean"; //필지정보
    $group_weather = "64,122"; //동네예보 XY좌표
    $group_weather_name = "오포읍";
    $group_center = "44239, 527971";
  break;

  default :
    echo "<script>alert('잘못된접근입니다.!');</script>";
  break;
}
*/


//echo $group_name;
?>
