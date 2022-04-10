function Masonry (className, options) {
	this.className = className;
	this.options = options;
	this.render();

	if(this.options.autoResize) {
		var timer = null;
		window.addEventListener("resize", () => {
			clearTimeout(timer);
			timer = setTimeout(() => {
				this.render();
			}, 300);
		})
	}
}

Masonry.prototype.render = function() {
	var columnWidth = this.options.columnWidth;
	var number = Math.floor(window.innerWidth / columnWidth);

	var newArr = [];
	for (var i = 0; i < number; ++i) {
		newArr.push(0);
	}

	document.querySelector(this.className).querySelectorAll(".masonry__item").forEach(function (item) {
		var index = 0;
		var min = newArr[index];
		for (var i = 0; i < number; ++i) {
			if (min > newArr[i]) {
				min = newArr[i];
				index = i;
			}
		}
		
		item.style.width = columnWidth + "px";
		item.style.left = index * columnWidth + "px";
		item.style.top = newArr[index] + "px";
		newArr[index] = newArr[index] + item.clientHeight;

	});

	var max = newArr[0];
	for (var i = 0; i < number; ++i) {
		if (max < newArr[i]) {
			max = newArr[i];
		}
	}
	document.querySelector(this.className).style.height = max + "px"
}