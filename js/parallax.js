//html elements

var item = document.getElementsByClassName('item');

//turn into array instead of an HTMLcollection so we can work with the elements
var itemArray = Array.from(item);



//input setup 

var input = {
    mouseX: {
        start: 0,
        end: window.innerWidth, //screens width
        current: 0,
    },

    mouseY: {
        start: 0,
        end: window.innerHeight,
        current: 0,
    }

};

input.mouseX.range = input.mouseX.end - input.mouseX.start;
input.mouseY.range = input.mouseY.end - input.mouseY.start;

//output
var output = {
    x: {
        start: -75,
        end: 75,
        current: 0,
    },
    y: {
        start: -75,
        end: 75,
        current: 0,
    },
};

output.x.range = output.x.end - output.x.start;
output.y.range = output.y.end - output.y.start;



var handleMouseMove = function (event) {
    //mouse x input
    input.mouseX.current = event.clientX;
    input.mouseX.fraction = (input.mouseX.current - input.mouseX.start) / input.mouseX.range;

    //mouse y input
    input.mouseY.current = event.clientY;
    input.mouseY.fraction = (input.mouseY.current - input.mouseY.start) / input.mouseY.range;

    //output x
    output.x.current = output.x.end - (input.mouseX.fraction * output.x.range);
    // output.x.current = output.x.start + (input.mouseX.fraction * output.x.range); //follows mouse

    //output y
    output.y.current = output.y.end - (input.mouseY.fraction * output.y.range);
    // output.y.current = output.y.start + (input.mouseY.fraction * output.y.range);

    // apply output to html //
    itemArray.forEach(function (item, i) {

        var depth = parseFloat(item.dataset.depth, 10); //parseFloat converts info into a number, put the 10 to make it a decimal system
        var itemOutput = {
            x: output.x.current - (output.x.current * depth), //math is a thing
            y: output.y.current - (output.y.current * depth),
            zIndex: 10000 - 10000 * depth // if our depth is 1, z-index will be 0
        };

        // console.log(i, 'depth', depth)

        //the magic
        item.style.zIndex = itemOutput.zIndex;
        item.style.transform = 'translate(' + itemOutput.x + 'px, ' + itemOutput.y + 'px)';



    });

    // console.log('output.x.current', output.x.current);
    //console.log('fraction Y' ,  input.mouseY.fraction);

}


var handleResize = function () {
    input.mouseX.end = window.innerWidth;
    input.mouseX.range = input.mouseX.end - input.mouseX.start;

    input.mouseY.end = window.innerHeight;
    input.mouseY.range = input.mouseY.end - input.mouseY.start;
}

//event listerners
window.addEventListener('mousemove', handleMouseMove);
window.addEventListener('resize', handleResize);