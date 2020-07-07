var iDam = 1
var iDaBung = 2;
var iDaMat = 3;
// Nut hien tai:
// > bat dau, tiep tuc
// < tam dung san soc, neu het 60 giay thi ket thuc tran dau
// ; tam dung xem xet
// Thay doi cac phim bam o day
var aDefKeys = Array(57, 190, 79, 49, 90, 81, 56, 188, 73, 50, 88, 87, 55, 77, 85, 51, 67, 69, 54, 78, 89, 52, 86, 82, 109, 107, 53, 48, 219, 221, 84, 80, 71, 66, 59);

var iMaxLoi = 50;
var oCurrCtrl = null;
var sMatchX1 = '';
var sMatchX2 = '';
var sMatchX3 = '';
var sMatchD1 = '';
var sMatchD2 = '';
var sMatchD3 = '';
var sMatchX21 = '';
var sMatchX22 = '';
var sMatchX23 = '';
var sMatchD21 = '';
var sMatchD22 = '';
var sMatchD23 = '';
var iAdded = 0;
var iAdded2 = 0;
var iTruX = 0;
var iTruD = 0;
// Thoi gian moi hiep tinh theo giay, vd 2 phut la 120 giay
var iTimeFight = 120;
var iTimeLeft = iTimeFight;
var bTickOn = true;
var bIsFighting = false;
var bInBreak = false;
var bPause = false;
var bPauseType = '';
var iPauseTime = 0;
var bPauseTick = true;
var iRoundCount = 1;
var iBtlCount = 1;
var iDau = 0;
var iCuoi = 0;
var iToiDa = 40;
var aMt = new Array();	// t1
var aMStatus = new Array();	// 0: Khong co gi, 1: Dang khop phim, 2: Ket thuc khop phim
var aMGroup = new Array();	// 0: Mat, 1: Bung, 2: Kho
var aMVDV = new Array();	// D: Do, X: Xanh
var aMKey = new Array();	// Luu iNum
var aMCount = new Array();	// So lan khop
var aDHien = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);	// So lan bam phim ben Do cua trong tai
var aXHien = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);	// So lan bam phim ben Xanh cua trong tai
var aNhom = Array('mat', 'bung', 'kho');
var t2;
var oDisplay = null;
var oDisplay2 = null;
var aCtrl = Array('PhimD12', 'PhimXTru', 'PhimXCong', 'PhimDTru', 'PhimDCong', //0, 1, 2, 3, 4
					'PhimXTruDiem', 'PhimXCongDiem', 'PhimDTruDiem', 'PhimDCongDiem',	//5, 6, 7, 8
					'PhimBatDau', 'PhimDungSS', 'PhimDungXX');	//9, 10, 11

// Remaining:
//	- Count down for SanSoc pause - Done
//	- Start button can be use to continue fighting after pause - Done
//	- Add 6 keys for increase / decrease score for each fighter, decrease half point - Done
//	- Allow press twice in a second

//http://stackoverflow.com/questions/610406/javascript-equivalent-to-printf-string-format/4673436#4673436
// First, checks if it isn't implemented yet.
if (!String.prototype.format) {
  String.prototype.format = function() {
    var args = arguments;
    return this.replace(/{(\d+)}/g, function(match, number) { 
      return typeof args[number] != 'undefined'
        ? args[number]
        : match
      ;
    });
  };
}

//"Thong tin tran dau"
function logFightInfo(sText, bReset)
{
	bReset=false;
	if(bReset) {
        ChamDiem.FightInfo.value = 'Trận\tHiệp\tGiây còn lại\tĐang đánh\tĐang nghỉ\tĐang dừng\tGiây ngưng\tSự kiện\tĐiểm Xanh\tLỗi Xanh\tĐiểm Đỏ\tLỗi Đỏ\n';
	}
    ChamDiem.FightInfo.value += '{0}\t{1}\t{2}\t{3}\t{4}\t{5}\t{6}\t{7}\t{8}\t{9}\t{10}\t{11}\n'.format(ChamDiem.TranSo.value, iRoundCount, iTimeLeft + (bTickOn ? '.0' : '.5'), bIsFighting, bInBreak, bPause, (!bPause ? 0 : iPauseTime + (bTickOn ? '.0' : '.5')), sText, ChamDiem.DiemX.value, ChamDiem.TruX.value, ChamDiem.DiemD.value, ChamDiem.TruD.value)
}

//"KHONG BIET"
function showDebug(sText, bCont) {
	if(oDisplay.document.getElementById('Debug')) {
		if(!bCont) oDisplay.document.getElementById('Debug').value = '';
		oDisplay.document.getElementById('Debug').value += sText;
	}
}

function onFocus(oCtrl) {
	//ChamDiem.Debug.value = 'onFocus: '+oCtrl.name.substr(0, 4);
	if(oCtrl.name.indexOf('Phim')>=0) oCurrCtrl = oCtrl;
	else oCurrCtrl = null;
	if(oCtrl.name.indexOf('TrongTai')>=0||oCtrl.name.indexOf('Diem')>=0
		||oCtrl.name.indexOf('Tru')>=0) oCtrl.blur();
	//ChamDiem.Debug.value = 'onFocus: '+oCurrCtrl.name;
}
function onKey(event, sType) {
	//ChamDiem.Debug.value = 'onKey: '+(oCurrCtrl?oCurrCtrl.name:'');//event.keyCode;
	if(sType=='up') {
		if(ChamDiem.elements[aCtrl[1]].value==event.keyCode)
			decrease('X', false);
		if(ChamDiem.elements[aCtrl[2]].value==event.keyCode)
			decrease('X', true);
		if(ChamDiem.elements[aCtrl[3]].value==event.keyCode)
			decrease('D', false);
		if(ChamDiem.elements[aCtrl[4]].value==event.keyCode)
			decrease('D', true);
		if(ChamDiem.elements[aCtrl[5]].value==event.keyCode)
			modify('X', 1);
		if(ChamDiem.elements[aCtrl[6]].value==event.keyCode)
			modify('X', -1);
		if(ChamDiem.elements[aCtrl[7]].value==event.keyCode)
			modify('D', 1);
		if(ChamDiem.elements[aCtrl[8]].value==event.keyCode)
			modify('D', -1);
		if(bIsFighting) {
			if(!bInBreak && !bPause) {
				for(var i=1; i<=12; i++) {	// 12 = 3 * 4
					if(ChamDiem.elements['PhimX'+i].value==event.keyCode) setMatch(i, 'X');
					if(ChamDiem.elements['PhimD'+i].value==event.keyCode) setMatch(i, 'D');
				}
			} else {
				// Do nothing
			}
		} else { // ~ if(!bIsFighting)
			if(ChamDiem.elements[aCtrl[9]].value==event.keyCode) {
				startFight();
			} else if(oCurrCtrl) {
				setKey(oCurrCtrl, event.keyCode);
			} else {
				// Do nothing
			}
		}
	} else { // ~ if(sType=='down')
		if(bIsFighting && !bInBreak) {
			if((bPause && ChamDiem.elements[aCtrl[9]].value==event.keyCode)) {
				// Continue fighting
				setPause('tt')
			} else if(!bPause && ChamDiem.elements[aCtrl[10]].value==event.keyCode) {
				// Pause with 1 minute limit (San Soc)
				setPause('ss');
			} else if(!bPause && ChamDiem.elements[aCtrl[11]].value==event.keyCode) {
				// Pause with no limit (Xem Xet)
				setPause('xx');
			} else {
				// Do nothing
			}
		} else {
			// Do nothing
		}
	}
}
function setPause(sType) {
	if(bPause) {
		logFightInfo('Tiếp tục đánh');
	}
	if(sType != '')
		bPause = !bPause;
	if(!bPause) {
		showInfo('HangCan');
		showInfo('GioiTinh');
		document.getElementById('DungSS').disabled = false;
		document.getElementById('DungXX').disabled = false;
	} else {
		bPauseType = sType;
		if(sType=='ss') {
			// Dung san soc 60 giay
			iPauseTime = 60;
			document.getElementById('DungXX').disabled = true;
			document.getElementById('GioiTinh').innerHTML = "SĂN SÓC";
			duplicateDisplay('GioiTinh');
			logFightInfo('Dừng săn sóc');
		} else if(sType=='xx') {
			// Dung xem xet
			iPauseTime = 0;
			document.getElementById('DungSS').disabled = true;
			document.getElementById('GioiTinh').innerHTML = "XEM XÉT";
			duplicateDisplay('GioiTinh');
			logFightInfo('Dừng xem xét');
		}
	}
}
function resetPause() {
	bPause = false;
	bPauseType = '';
	iPauseTime = 0;
	bPauseTick = true;
	setPause('')
}
function setKey(oCtrl, iKey) {
	//ChamDiem.Debug.value = 'setKey: '+ChamDiem.elements;
	for(var i=1; i<=12; i++) {
		if(('PhimX'+i)!=oCtrl.name&&ChamDiem.elements['PhimX'+i].value==iKey)
			// Clear conflict key
			ChamDiem.elements['PhimX'+i].value = '';
		if(('PhimD'+i)!=oCtrl.name&&ChamDiem.elements['PhimD'+i].value==iKey)
			// Clear conflict key
			ChamDiem.elements['PhimD'+i].value = '';
	}
	// Clear conflict for control keys
	for(i=1; i<=11; i++)
		if(oCtrl.name!=aCtrl[i]&&ChamDiem.elements[aCtrl[i]].value==iKey)
			ChamDiem.elements[aCtrl[i]].value = '';

	oCtrl.value = iKey;
	// Show string to assist saving default.
	ChamDiem.aDefKeys.value = 'Array(';
	for(i=1; i<=4; i++) {
		ChamDiem.aDefKeys.value += ChamDiem.elements['PhimX'+i].value+', ';
		ChamDiem.aDefKeys.value += ChamDiem.elements['PhimX'+(i+4)].value+', ';
		ChamDiem.aDefKeys.value += ChamDiem.elements['PhimX'+(i+8)].value+', ';
		ChamDiem.aDefKeys.value += ChamDiem.elements['PhimD'+i].value+', ';
		ChamDiem.aDefKeys.value += ChamDiem.elements['PhimD'+(i+4)].value+', ';
		ChamDiem.aDefKeys.value += ChamDiem.elements['PhimD'+(i+8)].value+', ';
	}

	// Add control keys
	for(i=1; i<=11; i++)
		ChamDiem.aDefKeys.value += ChamDiem.elements[aCtrl[i]].value+(i!=11?', ':');');

	// Move focus to next control key
	for(i=0; i<=11&&oCtrl.name!=aCtrl[i]; i++);
	//alert(i);
	if(i<11) {
		ChamDiem.elements[aCtrl[i+1]].focus();
	} else if(i==11) {
		//ChamDiem.DiemX.focus();
		oCtrl.blur();
		showHide('VungXacLapPhim');
	} else {
		var sChar = oCtrl.name.substr(4, 1);
		var iNum = Number(oCtrl.name.substr(5, 2));
		//ChamDiem.Debug.value = 'setKey: '+sChar+iNum+(sChar=='X'?iNum-8:iNum-8+1);
		ChamDiem.elements['Phim'+(iNum<=8?sChar:(sChar=='X'?'D':'X'))+(iNum<=8?iNum+4:(sChar=='X'?iNum-8:iNum-8+1))].focus();
	}
}
function setMatch(iNum, sVDV) {
// iNum: 1 den 12, so thu tu phim cham diem
// sVDV: X hay D
	var iThayDoi = 0;
	var iNhom = Math.floor((iNum-1) / 4);
	var iLan = 1;
	var iThay = -1;
//var aMt = new Array();	// t1
//var aMStatus = new Array();	// 0: Khong co gi, 1: Dang khop phim, 2: Ket thuc khop phim
//var aMGroup = new Array();	// 0: Mat, 1: Bung, 2: Kho
//var aMVDV = new Array();	// D: Do, X: Xanh
//var aMKey = new Array();	// Luu iNum
//var aMCount = new Array();	// So lan khop
//var aDHien = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);	// So lan bam phim ben Do cua trong tai
//var aXHien = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);	// So lan bam phim ben Xanh cua trong tai

	var i;
	var sTemp;
	// Tim xem nhom da co chua
	for(i=iDau; iThay<0 && i!=(iCuoi+1)%iToiDa; i=(i+1)%iToiDa) {	// Bug: iCuoi < iDau thi bi treo
		// Neu phim do da co thi qua nhom tiep theo
		if(sVDV==aMVDV[i] && aMKey[i].indexOf((iNum<10?'0':'')+iNum)>-1) {
		} else if((sVDV==aMVDV[i] && aMGroup[i]==iNhom)		// Phim chua co va trung nhom, tim thay nhom khop
			 ) iThay = i;
	}
	if(aMStatus[iThay]==1) {
		//showDebug(' Thay ' + sVDV + ' nhom ' + iNhom + ' phim so ' + iNum + ' tai ' + iThay, true);
		// Tim thay nhom ma khong trung phim
		aMCount[iThay]++;	// Tang so dem
		aMKey[iThay] += (iNum<10?'0':'') + iNum + ',';	// Ghi nhan lai phim, dau phay de tranh truong hop tim thay 10 trong 0103
		// Neu so dem = 3 thi tang diem
		logFightInfo('Tay bấm: {0}{1};Nhóm: {2};Đếm: {3}{4}'.format(sVDV, iNum, iNhom, aMCount[iThay], (document.getElementById('HaiTrongBa').checked?';2 trong 3':'')));
		if((aMCount[iThay]==3&&!document.getElementById('HaiTrongBa').checked)
			||(aMCount[iThay]==2&&document.getElementById('HaiTrongBa').checked)) {
			//if(sVDV=='X') ChamDiem.DiemX.value = Number(ChamDiem.DiemX.value) + (iNhom==0?iDaMat:(iNhom==1?iDam:iDaBung));
			//else ChamDiem.DiemD.value = Number(ChamDiem.DiemD.value) + (iNhom==0?iDaMat:(iNhom==1?iDam:iDaBung));
			modify(sVDV, (iNhom==0?iDaMat:(iNhom==1?iDam:iDaBung)));
		} else {
			// Do nothing
		}
	} else {
		// Nhom moi hay lan moi
		iCuoi = (iCuoi+1) % iToiDa;
		aMt[iCuoi] = setTimeout('clearMatch('+iCuoi+');', ChamDiem.TGKhopPhim.value);
		aMGroup[iCuoi] = iNhom;
		aMVDV[iCuoi] = sVDV;
		aMKey[iCuoi] = (iNum<10?'0':'') + iNum + ',';
		aMCount[iCuoi] = 1;
		aMStatus[iCuoi] = 1;
		logFightInfo('Tay bấm: {0}{1};Nhóm: {2};Đếm: {3}'.format(sVDV, iNum, iNhom, aMCount[iCuoi]));
		//showDebug(' Moi ' + aMVDV[iCuoi] + ' nhom ' + aMGroup[iCuoi] + ' phim so ' + aMKey[iCuoi] + ' tai ' + iCuoi, true);
	}

	// Hien cac o cho biet loai phim bam
	if(sVDV=='X') {
		aXHien[iNum-1]++;
		//showDebug(' aXHien ' + aXHien, true);
		sTemp = 'X' + aNhom[iNhom].charAt(0) + ((iNum-1)%4 + 1);
		oDisplay.document.getElementById(sTemp).src='img/'+aNhom[iNhom]+'Dot.gif';
		if(oDisplay2) oDisplay2.document.getElementById(sTemp).src='img/'+aNhom[iNhom]+'Dot.gif';
	} else if(sVDV=='D') {
		aDHien[iNum-1]++;
		//showDebug(' aDHien ' + aDHien, true);
		sTemp = 'D' + aNhom[iNhom].charAt(0) + ((iNum-1)%4 + 1);
		oDisplay.document.getElementById(sTemp).src='img/'+aNhom[iNhom]+'Dot.gif';
		if(oDisplay2) oDisplay2.document.getElementById(sTemp).src='img/'+aNhom[iNhom]+'Dot.gif';
	}
	//showDebug('iDau ' + iDau + ' iCuoi ' + iCuoi, false);
	showScore();
}
function clearMatch(iNhom) {
	var sTemp;
	aMStatus[iNhom] = 2;
	//showDebug(' Xoa ' + aMVDV[iNhom] + ' phim so ' + aMKey[iNhom] + ' tai ' + iNhom, true);
	for(var i=1; i<=12; i++) {
		// Giam lan hien dau hieu phim bam
		if(aMKey[iNhom].indexOf((i<10?'0':'')+i)>-1) {
			// Neu co phim thi giam so lan bam
			var sImg = '';
			if(aMVDV[iNhom]=='X') {
				aXHien[i-1]--;
				if(aXHien[i-1]==0) sImg = 'X';	// Dau hieu da het lan bam
				//showDebug(' aXHien ' + aXHien, true);
			} else if(aMVDV[iNhom]=='D') {
				aDHien[i-1]--;
				if(aDHien[i-1]==0) sImg = 'D';	// Dau hieu da het lan bam
				//showDebug(' aDHien ' + aDHien, true);
			}
			// Xoa cac dau hieu
			if(sImg!='') {
				sTemp = aMVDV[iNhom] + aNhom[aMGroup[iNhom]].charAt(0) + ((i-1)%4 + 1);
				oDisplay.document.getElementById(sTemp).src='img/'+sImg+'Dot.gif';
				if(oDisplay2) oDisplay2.document.getElementById(sTemp).src='img/'+sImg+'Dot.gif';
			}
		}
	}
	aMGroup[iNhom] = -1;
	aMVDV[iNhom] = '';
	aMKey[iNhom] = '';
	aMCount[iNhom] = 0;
	aMStatus[iNhom] = 0;
	iDau = (iDau + 1) % iToiDa;
	//showDebug('iDau ' + iDau + ' iCuoi ' + iCuoi, false);
}
function decrease(sVDV, bCancel) {
	if((ChamDiem.TruX.value<iMaxLoi&&ChamDiem.TruD.value<iMaxLoi)||bCancel) {
		if(sVDV=='X') {
			if(!bCancel) {
				ChamDiem.TruX.value++;
				//if(ChamDiem.TruX.value % 2==0) ChamDiem.DiemD.value++;
				ChamDiem.DiemD.value++;
			} else if(ChamDiem.TruX.value>0) {
				ChamDiem.TruX.value--;
				//if(ChamDiem.TruX.value % 2==1&&ChamDiem.DiemD.value>0) ChamDiem.DiemD.value--;
				ChamDiem.DiemD.value--;
			}
		} else {
			if(!bCancel) {
				ChamDiem.TruD.value++;
				//if(ChamDiem.TruD.value % 2==0) ChamDiem.DiemX.value++;
				ChamDiem.DiemX.value++;
			} else if(ChamDiem.TruD.value>0) {
				ChamDiem.TruD.value--;
				//if(ChamDiem.TruD.value % 2==1&&ChamDiem.DiemX.value>0) ChamDiem.DiemX.value--;
				ChamDiem.DiemX.value--;
			}
		}
	}
	showScore();
	logFightInfo('{0} lỗi: {1}'.format(bCancel?'Giảm':'Tăng', sVDV));
	if(ChamDiem.TruX.value>=iMaxLoi||ChamDiem.TruD.value>=iMaxLoi) doneFight();
}
function modify(sVDV, iDiem) {
	//alert(ChamDiem.DiemX.value+iDiem);
	if(sVDV=='X') {
		if(iDiem==1||iDiem==-2||Number(ChamDiem.DiemX.value)+iDiem>=0) ChamDiem.DiemX.value = Number(ChamDiem.DiemX.value) + (iDiem==-2?-1:iDiem);
	} else {
		if(iDiem==1||iDiem==-2||Number(ChamDiem.DiemD.value)+iDiem>=0) ChamDiem.DiemD.value = Number(ChamDiem.DiemD.value) + (iDiem==-2?-1:iDiem);
	}
	logFightInfo('{0} {1} điểm: {2}'.format(iDiem<0?'Giảm ':'Tăng ', Math.abs(iDiem), sVDV));
	showScore();
}
function startFight() {
	//if(ChamDiem.TruX.value<iMaxLoi-2&&ChamDiem.TruD.value<iMaxLoi-2) {
		iTimeLeft = ChamDiem.TGHiepDau.value;
		bTickOn = true;
		bIsFighting = true;
		bInBreak = false;
		resetPause();
		//alert('Start!');
		showTimeLeft();
		iRoundCount = 1;
		showRound(iRoundCount);
		t2 = setTimeout('inFight();', 500);
		document.getElementById('HaiManHinh').disabled = true;
		document.getElementById('HaiTrongBa').disabled = true;
		ChamDiem.BatDau.blur();
		ChamDiem.BatDau.disabled = true;
		document.getElementById('DungSS').disabled = false;
		document.getElementById('DungXX').disabled = false;
		ChamDiem.XoaDiem.disabled = true;
		ChamDiem.TGHiepDau.disabled = true;
		ChamDiem.TGNghiGiuaHiep.disabled = true;
		showScore();
		logFightInfo('Bắt đầu đánh', true);
	//}
}
function restartFight() {
	iTimeLeft = 60*Number(ChamDiem.DatLaiPhut.value) + Number(ChamDiem.DatLaiGiay.value);
	//alert(iTimeLeft);
	bIsFighting = true;
	bTickOn = true;
	bInBreak = false;
	resetPause();
	showTimeLeft();
	iRoundCount = Number(ChamDiem.DatLaiHiep.value);
	showInfo('HangCan');
	showInfo('GioiTinh');
	showRound(iRoundCount);
	// Bo bo dem gio cu truoc khi dat bo dem gio moi
	clearTimeout(t2);
	t2 = setTimeout('inFight();', 500);
	document.getElementById('HaiManHinh').disabled = true;
	document.getElementById('HaiTrongBa').disabled = true;
	ChamDiem.BatDau.disabled = true;
	document.getElementById('DungSS').disabled = false;
	document.getElementById('DungXX').disabled = false;
	ChamDiem.XoaDiem.disabled = true;
	ChamDiem.TGHiepDau.disabled = true;
	ChamDiem.TGNghiGiuaHiep.disabled = true;
	showScore();
	logFightInfo('Bắt đầu đánh lại');
}
function inFight() {
	if(!bPause) {
		bTickOn = !bTickOn;
		if(bTickOn) iTimeLeft--;
		showTimeLeft();
	} else {
		bPauseTick = !bPauseTick;
		if(bPauseTick) {
			if(bPauseType=="xx") iPauseTime++; // Count up for XemXet pause
			else iPauseTime--;	// Count down for SanSoc pause
		}
		showPauseTime();
		if(bPauseType=="ss" && iPauseTime==0) {
			// Time limit is reached, stop fighting
			doneFight();
		}
	}
	if(iTimeLeft==0||iRoundCount==4) {
		// Nghi giua hiep hay het tran dau
		if((iRoundCount==3&&(Number(ChamDiem.DiemD.value)!=Number(ChamDiem.DiemX.value)))
			||(iRoundCount==4&&(iTimeLeft==0||Math.abs(Number(ChamDiem.DiemD.value)-Number(ChamDiem.DiemX.value))>=ChamDiem.DiemDungHiep4.value))) {
			// Het tran dau neu diem khong bang nhau o cuoi hiep 3, hay khi het hiep 4
				//alert(Number(ChamDiem.DiemD.value)!=Number(ChamDiem.DiemX.value));
				//alert(Math.abs(Number(ChamDiem.DiemD.value)-Number(ChamDiem.DiemX.value)) + '\n' + ChamDiem.DiemDungHiep4.value)
				doneFight();
			//iTimeLeft = ChamDiem.TGHiepDau.value;
		} else if(iTimeLeft==0) {
			// Het hiep hay het gio nghi
			if(!bInBreak) {
				// Het hiep
				iTimeLeft = ChamDiem.TGNghiGiuaHiep.value;
				bTickOn = true;
				bInBreak = true;
				document.getElementById('DungSS').disabled = true;
				document.getElementById('DungXX').disabled = true;
				document.getElementById('GioiTinh').innerHTML = "GIỮA HIỆP";
				duplicateDisplay('GioiTinh');
				logFightInfo('Nghỉ giữa hiệp');
			} else {
				// Het gio nghi
				iRoundCount++;
				showRound(iRoundCount);
				iTimeLeft = ChamDiem.TGHiepDau.value;
				bTickOn = true;
				bInBreak = false;
				document.getElementById('DungSS').disabled = false;
				document.getElementById('DungXX').disabled = false;
				showInfo('GioiTinh');
				logFightInfo('Bắt đầu hiệp');
			}
		}
	}
	if(iTimeLeft>0&&bIsFighting) t2 = setTimeout('inFight();', 500);
	if(iTimeLeft>2&&iTimeLeft<=11&&iTimeLeft % 2==1&&!bTickOn) {
		//alert(document.getElementById('wavCountDown'));
		document.getElementById('wavCountDown').play();
	}
	if(iTimeLeft==1&&bTickOn)
		document.getElementById(bInBreak?'wavDoneBreak':'wavDoneFight').play();
}
function doneFight() {
	bIsFighting = false;
	bPause = false;
	bInBreak = false;
	ChamDiem.BatDau.disabled = false;
	document.getElementById('HaiManHinh').disabled = false;
	document.getElementById('HaiTrongBa').disabled = false;
	document.getElementById('DungSS').disabled = true;
	document.getElementById('DungXX').disabled = true;
	ChamDiem.XoaDiem.disabled = false;
	ChamDiem.TGHiepDau.disabled = false;
	ChamDiem.TGNghiGiuaHiep.disabled = false;
	if(Number(ChamDiem.DiemD.value)>Number(ChamDiem.DiemX.value)) blinkScore('DiemDo', true);
	if(Number(ChamDiem.DiemD.value)<Number(ChamDiem.DiemX.value)) blinkScore('DiemXanh', true);

	logFightInfo('Kết thúc');
	/*var sInfo = 'Trận đấu: ' + ChamDiem.FightInfo.value + String.fromCharCode(13,10);
	sInfo += 'Xanh: ' + ChamDiem.TenXanh.value;
	sInfo += ', Điểm: ' + ChamDiem.DiemX.value;
	sInfo += ', Trừ: ' + ChamDiem.TruX.value + String.fromCharCode(13,10);
	sInfo += 'Đỏ: ' + ChamDiem.TenDo.value;
	sInfo += ', Điểm: ' + ChamDiem.DiemD.value;
	sInfo += ', Trừ: ' + ChamDiem.TruD.value + String.fromCharCode(13,10);
	sInfo += 'Trọng tài 1: ' + String.fromCharCode(13,10);
	sInfo += 'Trọng tài 2: ' + String.fromCharCode(13,10);
	sInfo += 'Trọng tài 3: ' + String.fromCharCode(13,10);
	sInfo += 'Trọng tài 4: ' + String.fromCharCode(13,10);
	ChamDiem.FightInfo.value = sInfo + ChamDiem.FightInfo.value;*/
}
function newTimeLeft() {
	iTimeLeft = ChamDiem.TGHiepDau.value;
	bTickOn = true;
	showTimeLeft();
}
function showTimeLeft() {
	var oObj = oDisplay.document.getElementById('GioConLai');
	var sSec = iTimeLeft % 60;
	var sMin = (iTimeLeft-sSec) / 60;
	sMin = (sMin<10?'0':'')+String(sMin);
	sSec = (sSec<10?'0':'')+String(sSec);
	oObj.innerHTML = sMin+(bTickOn?':':'<font color="#000000">:</font>')+sSec;
	duplicateDisplay('GioConLai');
	//alert(oObj.innerHTML);
	/*
	var sPrefix = 'img/r';
	var sSurfix = 'med.gif';
	document.getElementById('min1').src = sPrefix+sMin.substr(0, 1)+sSurfix;
	document.getElementById('min2').src = sPrefix+sMin.substr(1, 1)+sSurfix;
	document.getElementById('Tick').src = 'img/'+(bTickOn||!bIsFighting?'-':'_')+'fdr.gif';
	document.getElementById('sec1').src = sPrefix+sSec.substr(0, 1)+sSurfix;
	document.getElementById('sec2').src = sPrefix+sSec.substr(1, 1)+sSurfix;
	*/
}
function showPauseTime() {
	var oObj = oDisplay.document.getElementById('HangCan');
	var sSec = iPauseTime % 60;
	var sMin = (iPauseTime-sSec) / 60;
	sMin = (sMin<10?'0':'')+String(sMin);
	sSec = (sSec<10?'0':'')+String(sSec);
	oObj.innerHTML = sMin+(bPauseTick?':':'<font color="#000000">:</font>')+sSec;
	duplicateDisplay('HangCan');
	//alert(oObj.innerHTML);
}
function showScore() {
	var sDiemX = ChamDiem.DiemX.value;
	var sDiemD = ChamDiem.DiemD.value;
	var iTruX = Number(ChamDiem.TruX.value);
	var iTruD = Number(ChamDiem.TruD.value);
	if(bIsFighting) {
		var sInfo = 'At ' + iTimeLeft + ' tick ' + (bTickOn?'on':'off');
		sInfo += ': X(' + sDiemX + '-' + iTruX;
		sInfo += ', M=' + sMatchX1 + ', B=' + sMatchX2 + ', K=' + sMatchX3;
		sInfo += ') D(' + sDiemD + '-' + iTruD;
		sInfo += ', M=' + sMatchD1 + ', B=' + sMatchD2 + ', K=' + sMatchD3 + ')' + String.fromCharCode(13, 10);
		//ChamDiem.FightInfo.value += sInfo;
	}
	//alert((sScore.length=0?0:(sScore.length=1?sScore:sScore.substr(1, 1))));
	//alert(oDisplay.document.getElementById('DiemXanh'));
	oDisplay.document.getElementById('DiemXanh').innerHTML = sDiemX;
	if(oDisplay2) oDisplay2.document.getElementById('DiemXanh').innerHTML = sDiemX;
	oDisplay.document.getElementById('DiemDo').innerHTML = sDiemD;
	if(oDisplay2) oDisplay2.document.getElementById('DiemDo').innerHTML = sDiemD;
	for(var i=1; i<=iMaxLoi; i++) {
		//if(i==12) alert(i + '\n' + iMaxLoi);
		showLoi('X', i, iTruX);
		showLoi('D', i, iTruD);
	}
}
function showLoi(sMau, i, iTru) {
	if((i<=iTru || i<20) && (i % 10==1) && oDisplay.document.getElementById(sMau+'tru'+i) == null) {
		var cellLoi = oDisplay.document.getElementById('tdLoi'+sMau);
		for(var j=i; j<i+10; j += 2) {
			// Each time new circle is needed, add batch of 5 to avoid mis-align.
			cellLoi.innerHTML += '\n\t\t\t\t' + (j % 10==1?'<br />':'&nbsp;') + '\n\t\t\t\t' + '<img id="' + sMau + 'tru' + j + '" class="DiemTru">';
			cellLoi.innerHTML += '<img id="' + sMau + 'tru' + (j + 1) + '" class="DiemTru">';
		}
		if(oDisplay2) oDisplay2.document.getElementById('tdLoi'+sMau).innerHTML = cellLoi.innerHTML;
		//if(i==12)
		//	alert(cellLoi.innerHTML+'\n'+i);
	}
	var imgLoi = oDisplay.document.getElementById(sMau+'tru'+i);
	if(imgLoi != null) {
		imgLoi.src = 'img/'+(i<=iTru?sMau+(i % 2==1?'NuaTrai':'NuaPhai'):sMau+'Dot')+'.gif';
		//if(i==12) alert(imgLoi.src + '\n' + i + '\n' + iTru);
		if(oDisplay2) oDisplay2.document.getElementById(sMau+'tru'+i).src = imgLoi.src;
	}
}
function blinkScore(sID, bBlinking) {
	var sDiem = document.getElementById((sID=='DiemXanh')?'DiemX':'DiemD').value;
	oDisplay.document.getElementById(sID).innerHTML = bBlinking?sDiem.blink():sDiem;
	duplicateDisplay(sID);
}
function clearScore() {
	if(ChamDiem.DiemX.value+ChamDiem.DiemD.value+ChamDiem.TruX.value+ChamDiem.TruD.value==0||
		confirm('Có thật sự muốn xóa điểm không?\n- Bấm OK là có\n- Bấm Cancel là không')==true) {
		//clearMatch();
		ChamDiem.DiemX.value = 0;
		ChamDiem.DiemD.value = 0;
		ChamDiem.TruX.value = 0;
		ChamDiem.TruD.value = 0;
		showScore();
	}
}
function showList() {
	var oList = document.getElementById('ChonTran');
	for(;oList.length>0;oList.remove(0));
	var aList = document.getElementById('DanhSachTran').value.split(String.fromCharCode(10));
	//alert(aList);
	for(var i=0; i<aList.length; i++)
		if(aList[i]!='') {
			//alert(aList[i]);//oList.add(aList[i], null);
			var y = document.createElement('option');
			y.text = aList[i].split(String.fromCharCode(9));
			y.value = i+1;
			try { oList.add(y, null); }
			catch(ex) { oList.add(y); }
		}
	if(aList.length>0) oList.selectedIndex=0;
	showAllInfo();
}
function showAllInfo() {
	var oList = document.getElementById('ChonTran');
	if(oList.length>0) {
		var aList = oList.options[oList.selectedIndex].text.split(',');
		if(aList.length<4) aList = oList.options[oList.selectedIndex].text.split(';');
	 	if(aList.length>=4) {
			//alert(aList);
			var i = (aList.length==5?1:0);
			ChamDiem.GioiTinh.value = aList[i];
			ChamDiem.HangCan.value = aList[i+1];
			ChamDiem.TenDo.value = aList[i+2];
			ChamDiem.TenXanh.value = aList[i+3];
		}
	}
	showInfo('TenXanh');
	showInfo('TenDo');
	showInfo('GioiTinh');
	showInfo('HangCan');
	showInfo('TranSo');
	clearScore();
	newTimeLeft();
}
function showRound(iRound) {
	oDisplay.document.getElementById('HiepSo').innerHTML = iRound;
	if(oDisplay2) oDisplay2.document.getElementById('HiepSo').innerHTML = oDisplay.document.getElementById('HiepSo').innerHTML
}
function showHide(sID, oFocusTo) {
	var oObj = oDisplay.document.getElementById(sID);
	oObj.style.display = oObj.style.display=='none'?'block':'none';
	if(oDisplay2 && oDisplay2.document.getElementById(sID)) oDisplay2.document.getElementById(sID).display = oObj.style.display;
	if(oFocusTo&&oObj.style.display!='none') oFocusTo.focus();
}
function showInfo(sID) {
	if(!oDisplay.document.getElementById(sID)) alert('DIV named '+sID+' not found! Please add it.');
	else if(!ChamDiem.elements[sID]) alert('INPUT TEXT named '+sID+' not found! Please add it.');
	else {
		oDisplay.document.getElementById(sID).innerHTML = ChamDiem.elements[sID].value!=''?ChamDiem.elements[sID].value:'';
		
		if(oDisplay2)
		{
			
			oDisplay2.document.getElementById(sID).innerHTML = oDisplay.document.getElementById(sID).innerHTML;
		} 
		
	}
}
function duplicateDisplay(sID) {
	if(oDisplay2) 
	oDisplay2.document.getElementById(sID).innerHTML = oDisplay.document.getElementById(sID).innerHTML;
}
function showDisplayWindow() {
	if(document.getElementById('HaiManHinh').checked) {
		//var oMainWin=window;	
		
		oDisplay2 = window.open('HienThi.php','_blank','location=yes;menubar=yes;status=no;toolbar=yes');
		//oMainWin.focus();
		/*alert('Tam dung de mo cua so hien thi. Vui long nhan OK khi cua so da hien ra xong.\nDe he thong hoat dong dung, cua so chinh phai luon duoHc chon.');*/
		//oDisplay2.document.getElementById('Display').innerHTML = oDisplay.document.getElementById('Display').innerHTML;
		//document.getElementById('Display').display = 'none';
	} else {
		//if(oDisplay&&oDisplay!=window) oDisplay.close();
		if(oDisplay2) oDisplay2.close();
		//oDisplay = window;
		//document.getElementById('Display').display = 'block';
		//alert(document.getElementById('Display').display);
	}
	showTimeLeft();
	showScore();
	showInfo('ThongTin');
	showInfo('TenXanh');
	showInfo('TenDo');
	showInfo('GioiTinh');
	showInfo('HangCan');
	showInfo('TranSo');
}
function onLoad() {
	for(i=1; i<=11; i++)
		ChamDiem.elements[aCtrl[i]].value = aDefKeys[i+24-1];
	ChamDiem.PhimX1.value = aDefKeys[0];
	ChamDiem.PhimX5.value = aDefKeys[1];
	ChamDiem.PhimX9.value = aDefKeys[2];
	ChamDiem.PhimD1.value = aDefKeys[3];
	ChamDiem.PhimD5.value = aDefKeys[4];
	ChamDiem.PhimD9.value = aDefKeys[5];
	ChamDiem.PhimX2.value = aDefKeys[6];
	ChamDiem.PhimX6.value = aDefKeys[7];
	ChamDiem.PhimX10.value = aDefKeys[8];
	ChamDiem.PhimD2.value = aDefKeys[9];
	ChamDiem.PhimD6.value = aDefKeys[10];
	ChamDiem.PhimD10.value = aDefKeys[11];
	ChamDiem.PhimX3.value = aDefKeys[12];
	ChamDiem.PhimX7.value = aDefKeys[13];
	ChamDiem.PhimX11.value = aDefKeys[14];
	ChamDiem.PhimD3.value = aDefKeys[15];
	ChamDiem.PhimD7.value = aDefKeys[16];
	ChamDiem.PhimD11.value = aDefKeys[17];
	ChamDiem.PhimX4.value = aDefKeys[18];
	ChamDiem.PhimX8.value = aDefKeys[19];
	ChamDiem.PhimX12.value = aDefKeys[20];
	ChamDiem.PhimD4.value = aDefKeys[21];
	ChamDiem.PhimD8.value = aDefKeys[22];
	ChamDiem.PhimD12.value = aDefKeys[23];
	oDisplay = window;
	showDisplayWindow();
	clearScore();
	showList();
}
function onUnload() {
	/*if(bIsFighting) {
		bPause = true;
		if(confirm('Có thật sự muốn ngưng trận đấu không?\n- Bấm OK là có\n- Bấm Cancel là không')==true) {
	*/		//clearInterval(t1);
			clearInterval(t2);
			doneFight();
			//if(document.getElementById('HaiManHinh').checked) oDisplay.close();
			if(oDisplay2) oDisplay2.close();
			//alert(oDisplay.closed);
	/*		return true;
		} else return bPause = false;
	}*/
}