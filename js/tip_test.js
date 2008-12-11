var myTips = new Class({
	Extends: Tips,
	Implements: [Options, Events],
        options: {
        className: 'customTip',
        morphToClass: 'customTipClosed',
        morphTime: '900',
		showDelay : 350,
		hideDelay : 100,
		offsets: {'x': -290, 'y': 0},
		fixed: 'true',
        },
	initialize: function(clicker, section, options) {
		this.setOptions(options);
		this.clicker = $(clicker).addEvent('click', this.toggle.bind(this));
		this.parent($(section), options);
		this.setup();
		this.attachEvents();		

	}
	setup: function(){..},
	attachEvents: function(){...},
	onShow: function(tip) {
						//this.morph.cancel();
						tip.fade('in');
						this.fx.start('.customTip','.customTipClosed');							
					},
	onHide: function(tip) {
						//this.morph.cancel();
						tip.fade('out');
						this.fx.start('.customTipClosed', '.customTip');						
					}
});

new myTips($('tool'), $('customtool'));