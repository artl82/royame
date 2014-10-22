/*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/


$(document).ready(
	function ()
	{
		$('#color-box').find('li').click(
			function()
			{
				$.cookie("theme",$(this).attr('class'));
				location.href = location.href.replace(/&theme=[^&]*/, '');
			}
		);

		$('#reset').click(
			function()
			{
				location.href = location.href.replace(/&theme=[^&]*/, '');
			}
		);

		$('#font').change(
			function()
			{
				location.href = location.href.replace(/&theme_font=[^&]*/, '')+'&theme_font='+$('#font option:selected').val();
			}
		);

		$('#gear-right').click(
			function()
			{
				if ($(this).css('left') == '215px')
				{
					$('#tool_customization').animate({left : '-215px'}, 500);
					$(this).animate({left : '0px'}, 500);
				}
				else
				{
					$('#tool_customization').animate({left : '0px'}, 500);
					$(this).animate({left : '215px'}, 500);
				}
			}
		);

		$('#theme-title').click(
			function()
			{
				if ($(this).children('i').hasClass('icon-caret-down'))
				{
					$(this).children('i').removeClass('icon-caret-down').addClass('icon-caret-up');
					$('#color-box').slideUp();
				}
				else
				{
					$(this).children('i').removeClass('icon-caret-up').addClass('icon-caret-down');
					$('#color-box').slideDown();
				}
			}
		);

		$('#slider-title').click(
			function()
			{
				if ($(this).children('i').hasClass('icon-caret-down'))
				{
					$(this).children('i').removeClass('icon-caret-down').addClass('icon-caret-up');
					$('#slider-box').slideUp();
				}
				else
				{
					$(this).children('i').removeClass('icon-caret-up').addClass('icon-caret-down');
					$('#slider-box').slideDown();
				}
			}
		);

		$('#adver-title').click(
			function()
			{
				if ($(this).children('i').hasClass('icon-caret-down'))
				{
					$(this).children('i').removeClass('icon-caret-down').addClass('icon-caret-up');
					$('#adver-box').slideUp();
				}
				else
				{
					$(this).children('i').removeClass('icon-caret-up').addClass('icon-caret-down');
					$('#adver-box').slideDown();
				}
			}
		);

		$('#logo-title').click(
			function()
			{
				if ($(this).children('i').hasClass('icon-caret-down'))
				{
					$(this).children('i').removeClass('icon-caret-down').addClass('icon-caret-up');
					$('#logo-box').slideUp();
				}
				else
				{
					$(this).children('i').removeClass('icon-caret-up').addClass('icon-caret-down');
					$('#logo-box').slideDown();
				}
			}
		);

		$('#background-title').click(
			function()
			{
				if ($(this).children('i').hasClass('icon-caret-down'))
				{
					$(this).children('i').removeClass('icon-caret-down').addClass('icon-caret-up');
					$('#background-box').slideUp();
				}
				else
				{
					$(this).children('i').removeClass('icon-caret-up').addClass('icon-caret-down');
					$('#background-box').slideDown();
				}
			}
		);

		$('#text-title').click(
			function()
			{
				if ($(this).children('i').hasClass('icon-caret-down'))
				{
					$(this).children('i').removeClass('icon-caret-down').addClass('icon-caret-up');
					$('#text-box').slideUp();
				}
				else
				{
					$(this).children('i').removeClass('icon-caret-up').addClass('icon-caret-down');
					$('#text-box').slideDown();
				}
			}
		);

		$('#link-title').click(
			function()
			{
				if ($(this).children('i').hasClass('icon-caret-down'))
				{
					$(this).children('i').removeClass('icon-caret-down').addClass('icon-caret-up');
					$('#link-box').slideUp();
				}
				else
				{
					$(this).children('i').removeClass('icon-caret-up').addClass('icon-caret-down');
					$('#link-box').slideDown();
				}
			}
		);

		$('#icon-title').click(
			function()
			{
				if ($(this).children('i').hasClass('icon-caret-down'))
				{
					$(this).children('i').removeClass('icon-caret-down').addClass('icon-caret-up');
					$('#icon-box').slideUp();
				}
				else
				{
					$(this).children('i').removeClass('icon-caret-up').addClass('icon-caret-down');
					$('#icon-box').slideDown();
				}
			}
		);
		
	  $.fn.mColorPicker.defaults = {
			imageFolder: 'img/admin/',
			swatches: [
			  "#ffffff",
			  "#ffff00",
			  "#00ff00",
			  "#00ffff",
			  "#0000ff",
			  "#ff00ff",
			  "#ff0000",
			  "#4c2b11",
			  "#3b3b3b",
			  "#000000"
			]
	  };
		
		$("#logo_type_image").click(function(){
			if($("input[name=logo_type]:checked").val()=="image"){
				$("#icp_logo_color, #logo_font, #logo_size, #logo_title").css("visibility","hidden");
				$("#logo_image").removeClass("hidden").addClass("display");
				$("#logo_text").removeClass("display").addClass("hidden");
				$.cookie("logo","image");}
			});

		$("#logo_type_text").click(function(){
			if($("input[name=logo_type]:checked").val()=="text"){
				$("#icp_logo_color, #logo_font, #logo_size, #logo_title").css("visibility","visible");
				$("#logo_image").removeClass("display").addClass("hidden");
				$("#logo_text").removeClass("hidden").addClass("display");
				$.cookie("logo","text");}
			});		

		if($.cookie("slider"))
		{
			if($.cookie("slider") == 'bx')
			{
				$('#slider_bx').attr("checked","checked");
				$('#slider_cy').removeAttr("checked");
			}
			else
			{
				$('#slider_cy').attr("checked","checked");
				$('#slider_bx').removeAttr("checked");
			}
		}
			
		$("#slider_bx").click(function()
		{
			$.cookie("slider","bx");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});

		$("#slider_cy").click(function()
		{
			$.cookie("slider","cy");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});	

		if($.cookie("featured"))
		{
			if($.cookie("featured") == 'multi')
			{
				$('#featured_mu').attr("checked","checked");
				$('#featured_bx').removeAttr("checked");
			}
			else
			{
				$('#featured_bx').attr("checked","checked");
				$('#featured_mu').removeAttr("checked");
			}
		}
			
		$("#featured_mu").click(function()
		{
			$.cookie("featured","multi");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});

		$("#featured_bx").click(function()
		{
			$.cookie("featured","slider");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});	

		if($.cookie("info"))
		{
			if($.cookie("info") == 'show')
			{
				$('#info_show').attr("checked","checked");
				$('#info_hide').removeAttr("checked");
			}
			else
			{
				$('#info_hide').attr("checked","checked");
				$('#info_show').removeAttr("checked");
			}
		}
			
		$("#info_show").click(function()
		{
			$.cookie("info","show");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});

		$("#info_hide").click(function()
		{
			$.cookie("info","slider");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});	

		if($.cookie("facebook"))
		{
			if($.cookie("facebook") == 'show')
			{
				$('#fb_show').attr("checked","checked");
				$('#fb_hide').removeAttr("checked");
			}
			else
			{
				$('#fb_hide').attr("checked","checked");
				$('#fb_show').removeAttr("checked");
			}
		}
			
		$("#fb_show").click(function()
		{
			$.cookie("facebook","show");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});

		$("#fb_hide").click(function()
		{
			$.cookie("facebook","slider");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});	

		// Reassure
		if($.cookie("reassure"))
		{
			if($.cookie("reassure") == 'show')
			{
				$('#re_show').attr("checked","checked");
				$('#re_hide').removeAttr("checked");
			}
			else
			{
				$('#re_hide').attr("checked","checked");
				$('#re_show').removeAttr("checked");
			}
		}
			
		$("#re_show").click(function()
		{
			$.cookie("reassure","show");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});

		$("#re_hide").click(function()
		{
			$.cookie("reassure","slider");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});	
		
		// gj_9561
		if($.cookie("gj9561"))
		{
			if($.cookie("gj9561") == 'show')
			{
				$('#gj9561_show').attr("checked","checked");
				$('#gj9561_hide').removeAttr("checked");
			}
			else
			{
				$('#gj9561_hide').attr("checked","checked");
				$('#gj9561_show').removeAttr("checked");
			}
		}
			
		$("#gj9561_show").click(function()
		{
			$.cookie("gj9561","show");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});

		$("#gj9561_hide").click(function()
		{
			$.cookie("gj9561","hide");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});			

		// gj_9551
		if($.cookie("gj9551"))
		{
			if($.cookie("gj9551") == 'show')
			{
				$('#gj9551_show').attr("checked","checked");
				$('#gj9551_hide').removeAttr("checked");
			}
			else
			{
				$('#gj9551_hide').attr("checked","checked");
				$('#gj9551_show').removeAttr("checked");
			}
		}
			
		$("#gj9551_show").click(function()
		{
			$.cookie("gj9551","show");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});

		$("#gj9551_hide").click(function()
		{
			$.cookie("gj9551","hide");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});			


		// gj_9541
		if($.cookie("gj9541"))
		{
			if($.cookie("gj9541") == 'show')
			{
				$('#gj9541_show').attr("checked","checked");
				$('#gj9541_hide').removeAttr("checked");
			}
			else
			{
				$('#gj9541_hide').attr("checked","checked");
				$('#gj9541_show').removeAttr("checked");
			}
		}
			
		$("#gj9541_show").click(function()
		{
			$.cookie("gj9541","show");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});

		$("#gj9541_hide").click(function()
		{
			$.cookie("gj9541","hide");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});			

		// gj_9531
		if($.cookie("gj9531"))
		{
			if($.cookie("gj9531") == 'show')
			{
				$('#gj9531_show').attr("checked","checked");
				$('#gj9531_hide').removeAttr("checked");
			}
			else
			{
				$('#gj9531_hide').attr("checked","checked");
				$('#gj9531_show').removeAttr("checked");
			}
		}
			
		$("#gj9531_show").click(function()
		{
			$.cookie("gj9531","show");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});

		$("#gj9531_hide").click(function()
		{
			$.cookie("gj9531","hide");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});			


		// gj_9521
		if($.cookie("gj9521"))
		{
			if($.cookie("gj9521") == 'show')
			{
				$('#gj9521_show').attr("checked","checked");
				$('#gj9521_hide').removeAttr("checked");
			}
			else
			{
				$('#gj9521_hide').attr("checked","checked");
				$('#gj9521_show').removeAttr("checked");
			}
		}
			
		$("#gj9521_show").click(function()
		{
			$.cookie("gj9521","show");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});

		$("#gj9521_hide").click(function()
		{
			$.cookie("gj9521","hide");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});			

		// gj_9511
		if($.cookie("gj9511"))
		{
			if($.cookie("gj9511") == 'show')
			{
				$('#gj9511_show').attr("checked","checked");
				$('#gj9511_hide').removeAttr("checked");
			}
			else
			{
				$('#gj9511_hide').attr("checked","checked");
				$('#gj9511_show').removeAttr("checked");
			}
		}
			
		$("#gj9511_show").click(function()
		{
			$.cookie("gj9511","show");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});

		$("#gj9511_hide").click(function()
		{
			$.cookie("gj9511","hide");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});			

		// cp_1901
		if($.cookie("cp1901"))
		{
			if($.cookie("cp1901") == 'show')
			{
				$('#cp1901_show').attr("checked","checked");
				$('#cp1901_hide').removeAttr("checked");
			}
			else
			{
				$('#cp1901_hide').attr("checked","checked");
				$('#cp1901_show').removeAttr("checked");
			}
		}
			
		$("#cp1901_show").click(function()
		{
			$.cookie("cp1901","show");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});

		$("#cp1901_hide").click(function()
		{
			$.cookie("cp1901","hide");
			location.href = location.href.replace(/&theme=[^&]*/, '');
		});			
		
	}		
);

function get(name)
{
	var regexS = "[\\?&]" + name + "=([^&#]*)";
	var regex = new RegExp(regexS);
	var results = regex.exec(window.location.href);

	if (results == null)
		return "";
	else
		return results[1];
}