function superslidermenu(menuid, holder,toggler,content,toglink,add_mouse,alwaysHide,opacity,trans_time,trans_type,follow,fspeed){
	
	//  IE6
	if(window.ie6) var heightValue ='100%';
	else var heightValue = '';

	var togglerName =  toggler;
	var contentName =  content;	
	var counter = 1;	
	var toggler = $$(togglerName+counter);
	var content = $$(contentName+counter);	
	var catName = toglink;
	var togCat = $$(holder+catName);	
	var navArrow = 'navArrow' + menuid;

	while(toggler.length>0) {

    // cookie opener start
    function autoOpen( myCount ) {
//console.log('myCount ' + myCount +' .');
		toggler.each(function(el, i) { 
				el.addEvent('click', function() {
					Cookie.write(('menuOpen'+myCount), i);

				});	
			});
			
		 togCat.each(function(el, i) { 
				el.addEvent('click', function() {				
					Cookie.write(('menuOpen'+myCount), i);
				});	
			});
		if (Cookie.read('menuOpen'+myCount)) { 
				var menuOpened = Cookie.read(('menuOpen'+myCount)).toInt();
			
			}else { 
				menuOpened = -1;
			}
		menuOpenAt = menuOpened;
			
	}//end autoOpen	function
	mycounter = counter - 1;
	
		if (counter == 1){
			autoOpen(mycounter);			
		}else if (counter == 2){
			autoOpen(mycounter);
		}else if (counter == 3){
			autoOpen(mycounter);	
		}else if (counter == 4){
			autoOpen(mycounter);
		}else{
			menuOpenAt = -1;
		}

		new Fx.Accordion(toggler, content, {
			opacity: opacity,			//- (boolean: defaults to true) If set to true, an opacity transition effect will take place when switching between displayed elements.
			display: menuOpenAt,		//- (integer: defaults to 0) The index of the element to show at start (with a transition).
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
				var tomorph = toggler.parentNode;
				var togglerMorph = new Fx.Morph(tomorph, {duration: 1100, transition: Fx.Transitions.Sine.easeOut});
 				togglerMorph.start('.tabopen');
				toggler.parentNode.getParent().setStyle('height', heightValue);
				toggler.getParent().getParent().getParent().setStyle('height', heightValue);
							
			},
			onBackground: function(toggler, content) {				
				toggler.removeClass('open');
				var tomorph = toggler.parentNode;
				var togglerMorph = new Fx.Morph(tomorph, {duration: 400, transition: Fx.Transitions.Sine.easeOut});
 				togglerMorph.start('.tabclosed');

			}
		});		
		if (add_mouse == 'on'){
			toggler.addEvent('mouseenter', function() { this.fireEvent('click'); });
		}
		counter++;
		toggler=$$(togglerName+counter);
		content=$$(contentName+counter);		
	};
		
	var mhc = holder.replace('#',''); // this removes the pound sign from the holder id
	clear_link(mhc);// this identifies the active page
	
	//this is the nav arrow follow creator
	if (follow == 'on'){		
		make_arrow(navArrow, holder, mhc,fspeed);
		};
	
//} // end superslider function

	/*
	*	 identify active page remove link and add id
	*/
	function clear_link(mhc){ 
		var unlinked = 0;
		var aNav = $(mhc);
		var a = aNav.getElementsByTagName('a');
		var mysplit = window.location.href.split('#')[0];
		for(var i=1;i<a.length;i++)
			if(a[i].href == mysplit){
				removeNode(a[i]);

 			var unlinked = 1;
				}				
			if (unlinked == 0){
				var newHit = a[0];
				newHit.parentNode.addClass ('active_nav'); 
			}
	}
	function removeNode(n){
		if(n.hasChildNodes())
			for(var i=0;i<n.childNodes.length;i++)
		
		n.parentNode.insertBefore(n.childNodes[i].cloneNode(true),n);
		n.parentNode.addClass('active_nav');
		n.parentNode.removeChild(n);
	}

	function make_arrow(navArrow,holder,mhc,fspeed){
		
			var arrowHome = $(mhc);
			var myArrow = new Element('div', {
				'id': navArrow,
				styles:{'top': '0',
						'height':'100%',
						'z-index': '100',
						'overflow': 'hidden',
						'position': 'absolute'},
				'class': 'myNavArrow'
				}).inject(arrowHome);
				
			followme(navArrow,holder,fspeed);
	}
	
	function followme(navArrow,holder,fspeed){

	var navArrow = $(navArrow);
				var destination = holder+' span' +', '+ holder+' div';	
				navArrowFollow(
				navArrow,				// ID of arrow wrap
				destination,			// Array selector for arrow destinations
				'active_nav',			// ID of current nav element
				0,						//  Background position x of background image
				22,						//  y0ffset
				fspeed					//  speed of movment
				);		
	} 
} // end superslider function
