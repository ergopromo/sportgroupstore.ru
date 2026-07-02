if (!window.BX_YMapAddPlacemark)
{
	window.BX_YMapAddPlacemark = function(map, arPlacemark)
	{
		if (null == map)
			return false;

		if(!arPlacemark.LAT || !arPlacemark.LON)
			return false;

 
		let MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
		'<div class="map_popover">' +
			'<svg class="map_popover__close" width="12" height="12" viewBox="0 0 12 12">'+
			'<path d="M1 1L6 6M11 11L6 6M6 6L11 1.00003M6 6L1 11" stroke-linecap="round"/>'+
			'</svg>' +
			'<div class="map_popover__arrow"></div>' +
			'<div class="map_popover__inner">' +
			'$[[options.contentLayout observeSize minWidth=240 maxWidth=240 maxHeight=350]]' +
			'</div>' +
			'</div>', {
			
			build: function () {
				this.constructor.superclass.build.call(this);

				this._$element = $('.map_popover', this.getParentElement());

				this.applyElementOffset();

				this._$element.find('.map_popover__close')
					.on('click', $.proxy(this.onCloseClick, this));
			},

			
			clear: function () {
				this._$element.find('.map_popover__close')
					.off('click');

				this.constructor.superclass.clear.call(this);
			},

			
			onSublayoutSizeChange: function () {
				MyBalloonLayout.superclass.onSublayoutSizeChange.apply(this, arguments);

				if(!this._isElement(this._$element)) {
					return;
				}

				this.applyElementOffset();

				this.events.fire('shapechange');
			},

			
			applyElementOffset: function () {
				this._$element.css({
					left: -(this._$element[0].offsetWidth / 2),
					top: -(this._$element[0].offsetHeight + this._$element.find('.map_popover__arrow')[0].offsetHeight)
				});
			},

			
			onCloseClick: function (e) {
				e.preventDefault();

				this.events.fire('userclose');
			},

			_isElement: function (element) {
				return element && element[0] && element.find('.map_popover__arrow')[0];
			}
		});


		let MyBalloonContentLayout = ymaps.templateLayoutFactory.createClass(
				'<div class="map-popover__content content_balloon">$[properties.balloonContent]</div>'
		);

		var props = {};
		if (null != arPlacemark.TEXT && arPlacemark.TEXT.length > 0)
		{
			var value_view = '';

			if (arPlacemark.TEXT.length > 0)
			{
				var rnpos = arPlacemark.TEXT.indexOf("</h2>");
				value_view = rnpos <= 0 ? arPlacemark.TEXT : arPlacemark.TEXT.substring(0, rnpos) + '</h2>';
			}

			props.hintContent = value_view;
			props.balloonContent= arPlacemark.TEXT;

		}

		var params = {
			balloonCloseButton: true,
			balloonShadow: false,
			balloonLayout: MyBalloonLayout,
            balloonContentLayout: MyBalloonContentLayout,
		};

		if(null != arPlacemark.MARKER && arPlacemark.MARKER.length > 0) {
			params.iconImageHref = arPlacemark.MARKER;
		}
		else {
			MyIconLayout = ymaps.templateLayoutFactory.createClass([
				'<svg width="24" height="30" viewBox="0 0 24 30" fill="none">'+
				'<path d="M24 10.9589C23.7414 19.5797 15.0106 27.4878 12.6071 29.5052C12.2519 29.8034 11.7522 29.7974 11.4025 29.4928C8.97761 27.3804 0 19.0159 0 10.9589C0 4.90647 5.37258 0 12 0C18.6274 0 24 4.90647 24 10.9589Z" fill="var(--main-color)"/>'+
				'<ellipse cx="12" cy="11.5909" rx="4.94118" ry="4.77273" fill="white"/>'+
				'</svg>'
			].join(''));
			params.iconLayout = MyIconLayout;
		}

		var obPlacemark = new ymaps.Placemark(
			[arPlacemark.LAT, arPlacemark.LON],
			props,
			params
		);

		map.geoObjects.add(obPlacemark);

		obPlacemark.events.add("balloonopen", function(){
			map.setCenter([+obPlacemark.geometry.getCoordinates()[0]+3,obPlacemark.geometry.getCoordinates()[1]]);
		});
		return obPlacemark;
	}
}

if (!window.BX_YMapAddPolyline)
{
	window.BX_YMapAddPolyline = function(map, arPolyline)
	{
		if (null == map)
			return false;

		if (null != arPolyline.POINTS && arPolyline.POINTS.length > 1)
		{
			var arPoints = [];
			for (var i = 0, len = arPolyline.POINTS.length; i < len; i++)
			{
				arPoints.push([arPolyline.POINTS[i].LAT, arPolyline.POINTS[i].LON]);
			}
		}
		else
		{
			return false;
		}

		var obParams = {clickable: true};
		if (null != arPolyline.STYLE)
		{
			obParams.strokeColor = arPolyline.STYLE.strokeColor;
			obParams.strokeWidth = arPolyline.STYLE.strokeWidth;
		}
		var obPolyline = new ymaps.Polyline(
			arPoints, {balloonContent: arPolyline.TITLE}, obParams
		);

		map.geoObjects.add(obPolyline);

		return obPolyline;
	}
}