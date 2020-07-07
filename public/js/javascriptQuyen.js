// JavaScript Document

var oDisplayShow = null;
var oDisplayShowPoint = null;
var oDisplays = null;
function onloadd()
{
	oDisplays = window;
}

function show(sid)
{
	//oDisplayShow = window.open('showResult.php?sID=' + sid,'_blank','height='+screen.height+', width='+screen.width);
	if(!oDisplayShow)
	{
		oDisplayShow = window.open('showResult.php?sID=' + sid,'_blank','location=yes;menubar=yes;status=no;toolbar=yes');
	}
	else
	{
		oDisplayShow.close();
	}
	
}

function phanTrangRank(i)
				{
					$.ajax({
					url: 'loadRank.php?i='+i,
					type: 'POST',
					success: function(response){
						$('.danhsachRank').html(response);
						//$("#delete").attr("disabled", true);
						//$("#edit").attr("disabled", true);
						
					}
				})
				}




