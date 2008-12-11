function superslidermenu(holder,toggler,content,toglink,add_mouse,alwaysHide,opacity,trans_time,trans_type,follow,fside,fspeed){

	//  IE6
	if(window.ie6) {var heightValue='100%';}
	else {var heightValue='';}
		
	//var mh = holder;

	var togglerName = holder+ toggler;
	var contentName = holder+ content;
	
	var counter=1;	
	var toggler=$$(togglerName+counter);
	var content=$$(contentName+counter);
	
	var catName = toglink;
	var togCat =$$(holder+catName);

	
	while(toggler.length>1)
	{
//new cookie opener start
	function autoOpen(myCount)
		{		
		toggler.each(function(el, i)
			{ 
				el.addEvent('click', function()
				{
					Cookie.write(('menuOpen'+myCount), i);
					//console.log('the menuOpen clicked is ' + Cookie.read(('menuOpen'+myCount)) +' .');
				});	
			});
			
		togCat.each(function(el, i)
			{ 
				el.addEvent('click', function()
				{
					Cookie.write(('menuOpen'+myCount), i);
					//alert('the togcat clicked is ' + Cookie.read(('menuOpen'+myCount)) +' .');
				});	
			});
		if (Cookie.read('menuOpen'+myCount))
			{ 
				var menuOpened = Cookie.read(('menuOpen'+myCount)).toInt();
			}else { 
				menuOpened = -1;
			}
		menuOpenAt = menuOpened;// set your Accordian to display:menuOpenAt or show:menuOpenAt
			
	}//end autoOpen	
		if (counter == 1){
			autoOpen(0);			
		}else if (counter == 2){
			autoOpen(1);
		}else if (counter == 3){
			autoOpen(2);	
		}else if (counter == 4){
			autoOpen(3);
		}else{
			menuOpenAt = -1;
		}		
//new cookie opener stop

// Accordion 
		new Accordion(toggler, content, {
			opacity: opacity,			//- (boolean: defaults to true) If set to true, an opacity transition effect will take place when switching between displayed elements.
			display: menuOpenAt,		//- (integer: defaults to 0) The index of the element to show at start (with a transition).
			//show: menuOpenAt,			//- (integer: defaults to 0) The index of the element to be shown initially.
			alwaysHide: alwaysHide,		//- (boolean: defaults to false) If set to true, it will be possible to close all displayable elements. Otherwise, one will remain open at all time.
			height: true, 				//- (boolean: defaults to true) If set to true, a height transition effect will take place when switching between displayed elements.
			width: false,				//- (boolean: defaults to false) If set to true, a width transition will take place when switching between displayed elements.
			fixedHeight: false, 		//- (boolean: defaults to false) If set to false, displayed elements will have a fixed height.
			fixedWidth: false, 			//- (boolean: defaults to false) If set to true, displayed elements will have a fixed width.
			duration: trans_time,		// - (number: defaults to 500) The duration of the effect in ms. Can also be one of:
			transition: trans_type,		//'quad:in:out'sine:out, elastic:out, bounce:out, expo:out, circ:out, quad:out, cubic:out, linear:out,			
			onComplete: function() { 
				var element=$(this.elements[this.previous]);
				if(element && element.offsetHeight>0) element.setStyle('height', heightValue);	
				
			},
			onActive: function(toggler, content) {
				toggler.addClass('open');
				
				//toggler.parentNode.setStyle('background', '#000');
				
				var tomorph = toggler.parentNode;
				var togglerMorph = new Fx.Morph(tomorph, {duration: 1100, transition: Fx.Transitions.Sine.easeOut});
 				togglerMorph.start('.tabopen');
 				
				toggler.getParent().getParent().getParent().setStyle('height', heightValue);
 				
				
			},
			onBackground: function(toggler, content) {
				toggler.removeClass('open');
				
				var tomorph = toggler.parentNode;
				var togglerMorph = new Fx.Morph(tomorph, {duration: 400, transition: Fx.Transitions.Sine.easeOut});
 				togglerMorph.start('.tabclosed');

			},onComplete: function(){	
				
        	//this.display.delay(400, this, (this.previous + 1) % this.togglers.length);

		   	}
			
			
		});		
		if (add_mouse == 'on'){
			toggler.addEvent('mouseenter', function() { this.fireEvent('click'); });
		}
			
		// Levels
		counter++;
		toggler=$$(togglerName+counter);
		content=$$(contentName+counter);		
	};
	
	// this removes the poung sign from the holder id
	var mhc = holder.replace('#',''); 

	 clear_link(mhc);// this identifies the active page
	
	//this is the nav arrow follow creator
	if (follow == 'on'){		
		make_arrow(holder, mhc, fside,fspeed);
		};	
		
} // end superslider function

	/*
	*	 identify active page remove link and add id
	*/
	function clear_link(mhc){ 
		var unlinked = 0;
		var aNav = $(mhc);
		var a = aNav.getElementsByTagName('A');
		for(var i=0;i<a.length;i++)
			if(a[i].href == window.location.href.split('#')[0]){
				removeNode(a[i]);
				var unlinked = 1;
				}				
			if (unlinked == 0){
				var newHit = a[0];
				newHit.parentNode.setProperty ('id','active_nav'); 
			}
	}
	function removeNode(n){
		if(n.hasChildNodes())
			for(var i=0;i<n.childNodes.length;i++)
				n.parentNode.insertBefore(n.childNodes[i].cloneNode(true),n);
		
		n.parentNode.setProperty('id','active_nav');
		n.parentNode.removeChild(n);
	   
	}
	/*
	*	scroller for linksList
	*/

	function scrollLinksList(){
	
		var myList = $('.linkslist');
		var listScroller = new Scroller(myList, {area:40, velocity:1});
		myList.addEvent('mouseenter', scroll.start.bind(listScroller));
		myList.addEvent('mouseleave', scroll.stop.bind(listScroller));
		
		//$('container').addEvent('mouseleave', scroll.stop.bind(scroll));
	
		//listScroller.start();
		
	}

	/*
	*	this creates the nav arrow
	*/
	
	
	function make_arrow(holder,mhc,fside,fspeed){
			
			//side = ("'"+fside+"'");
			//console.log('the side is ' + side +' .');
			//mystyles = "styles:{'top': '0', "+side+":'0','height':'100%','width':'10px','z-index': '1005','overflow': 'hidden','position': 'absolute'}";			
			//console.log('the mystyles is ' + mystyles +' .');
			// I can't seem to get the fside (which is right or left) into the styles list bellow.
			var arrowHome = $(mhc);
			
			var myArrow = new Element('div', {
				'id': 'navArrow',
				styles:{'top': '0', 
						//'right':'0',
						'height':'100%',
						//'width':'10px',
						'z-index': '1005',
						'overflow': 'hidden',
						'position': 'absolute'},
				'class': 'myNavArrow'
				}).inject(arrowHome);
				
			followme(holder,fspeed);
	}
	
	function followme(holder,fspeed){
				var destination = holder+' span' +', '+ holder+' dt';	
				navArrowFollow(
				'navArrow',				// ID of arrow wrap
				destination,			// Array selector for arrow destinations
				//'#ssMenuList span, #ssMenuList dt',
				'active_nav',			// ID of current nav element
				0,						//  Background position x of background image
				22,						//  y0ffset
				fspeed					//  speed of movment
				);		
	} 
