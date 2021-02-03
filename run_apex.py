from shutil import copy2
from os import popen, system, chdir
from subprocess import call
import sys

#   APEX 구동 경로 설정
run_dir = 'C:/inetpub/wwwroot/APEX/apex_run/'
main_dir = 'C:/inetpub/wwwroot/APEX/'
#   PHP에서 전달 받은 변수를 통해서 입력파일 경로 설정
input_dir = 'C:/inetpub/wwwroot/APEX/input_folder/'+sys.argv[1]+'/'
#input_dir = 'C:/inetpub/wwwroot/APEX/input_folder/203.252.82.93/'

#   입력자료 구동폴더로 복사+붙여넣기
inputs = ['APEXCONT.DAT','APEXRUN.DAT','WINAPEX.SIT','WINAPEX.SUB']
for i in inputs:
    copy2(input_dir+i,run_dir)

chdir(run_dir)

try:
    call('APEX1501.exe')
    print ('success')
except:
    out = open('output.txt','w')
    print ('fail')

chdir(main_dir)

#   결과파일 열기 SAD
f = open('apex_run/Winapex.SAD', 'r')
#   결과파일 읽기
temp_lines = f.readlines()[9:]
temp_lines2 = []
temp_lines3 = []

#   결과파일 값 분류하기
for r in range(len(temp_lines)):
    temp_lines[r] = temp_lines[r].replace('\n', '')
    temp_lines[r] = temp_lines[r].split(' ')
for r in range(len(temp_lines)):
    for k in range(len(temp_lines[r])):
        if temp_lines[r][k] != '':
            temp_lines2.append(temp_lines[r][k])
    temp_lines3.append(temp_lines2)
    temp_lines2 = []
print (temp_lines3[:2])
#   temp_lines3에 결과 LIST가 저장됨
#   Save results as list



#   일자별로 정리하기

#   헤더텍스트를 기준으로 인덱스 추출
#       일자 정보
Y = temp_lines3[0].index('Y')
M = temp_lines3[0].index('M')
D = temp_lines3[0].index('D')

#       유량 정보
Q = temp_lines3[0].index('Q')
SSF = temp_lines3[0].index('SSF')
QRF = temp_lines3[0].index('QRF')
RSSF = temp_lines3[0].index('RSSF')

#       TN 계산하기
QN = temp_lines3[0].index('QN')
YN = temp_lines3[0].index('YN')
RSFN = temp_lines3[0].index('RSFN')


#   리스트로 결과 저장
APEX_date = []
outflow = []
TN = []
for i in temp_lines3:
    temp_date = ("'"+i[Y]+"-"+i[M]+"-"+i[D]+"'")
    APEX_date.append(temp_date)
    try:
        temp_outflow = round((float(i[Q])+float(i[SSF])+float(i[QRF])+float(i[RSSF])),4)
        outflow.append(temp_outflow)
        
        #   현재 TN 계산은 YN이 제외된 상태
        temp_TN = round((float(i[QN])+float(i[RSFN])),4)
        TN.append(temp_TN)
    except:
        outflow.append('outflow')
        TN.append('TN')



#결과파일 CSV로 저장하기
outfile = open('result.csv','w')
for i in range(1,len(APEX_date)):
    outfile.write(APEX_date[i]+','+str(outflow[i])+','+str(TN[i])+'\n')
outfile.close()
