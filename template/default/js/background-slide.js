/*
 * JCat Background Image Slider
 * Взят с сайта: http://javascript.ru/forum/showthread.php?p=331963
 * Автор: hfts_rider
 * Доработал: Johny_Cat
 * Работает на JQuery
*/

var imgHead = [
			'/template/default/images/1.jpg',
			'/template/default/images/2.jpg',
			'/template/default/images/3.jpg',
			'/template/default/images/4.jpg',
			'/template/default/images/5.jpg'
		], i=1;
	function BGSlide(){

		if(i > (imgHead.length-1)){
			$('.placeholder .background').animate({'opacity':'0'},1000,function(){
				i=1;
				$('.placeholder .background').css('background','url('+imgHead[0]+') 50% 15% / cover no-repeat');
			});
			$('.placeholder .background').animate({'opacity':'1'},1000);
		}else{
			$('.placeholder .background').animate({'opacity':'0'},1000,function(){
				$('.placeholder .background').css('background','url('+imgHead[i]+') 50% 15% / cover no-repeat');
				i++;
			});
			$('.placeholder .background').animate({'opacity':'1'},1000);
		}
		
	}
	var intervalBGSlide = setInterval(BGSlide,15000);