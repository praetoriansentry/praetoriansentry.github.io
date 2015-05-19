// Get used to looking through code
// Practice hacking something together

(function() {
    "use strict";

    var GROW_COUNT = 2; // This is the number of segments that a snake will grow after eating something
    var s, ss;

    // The snake is modeled like a linked list. It's a collection of
    // segments. Each segment has an X and Y coorindate as well as
    // pointers to the previous and next segment
    function SnakeSegment() {
        this.previous = null;
        this.next = null;
        this.x = null;
        this.y = null;
    }

    ss = SnakeSegment.prototype;

    // The snake grows when it eats something. This function is used
    // to clone existing segments of the snake when it needs to grow
    ss.clone = function() {
        var seg = new SnakeSegment();
        seg.x = this.x;
        seg.y = this.y;
        seg.previous = this.previous;
        seg.next = this.next;
        return seg;
    };

    // In JavaScript, this type of function is known as a
    // constructor. That means it can be used with the ~new~ keyword
    // to create a new object.
    function Snake(maxX, maxY) {
        this.maxX = maxX;
        this.maxY = maxY;
        this.head = null;
        this.tail = null;
        this.directionX = 0;
        this.directionY = 0;
        this.growCount = 0;

        this.init();
    }

    s = Snake.prototype;

    // This function is called by the constructor. It creates a new
    // segment that represents a new snake. It also sets the snake
    // location to a spot about 20% in from the edges
    s.init = function() {
        var seg = new SnakeSegment();
        seg.x = Math.round((this.maxX * 0.2) / 10) * 10;
        seg.y = Math.round((this.maxY * 0.2) / 10) * 10;

        this.head = seg;
        this.tail = seg;
    };

    // This isn't a particularly important function. It explicitly
    // maps direction vectors into a single number that's easier to
    // use for comparisions
    s.getDirectionNumber = function(x, y) {
        if (x > 0) {
            return 0;
        }
        if (x < 0) {
            return 1;
        }
        if (y > 0) {
            return 2;
        }
        if (y < 0) {
            return 3;
        }
    };

    // This function is used to specify which direction the snake is
    // facing. Right now the only acceptible inputs are 1 and -1.
    s.setDirection = function(x, y) {
        var head = this.head;
        var neck = this.head.next;

        var dir = this.getDirectionNumber(x, y);

        // If the snake is more than 1 segment long, we need to check
        // to make sure the snake doesn't turn into itself
        if (neck) {
            var dx = neck.x - head.x;
            var dy = neck.y - head.y;

            var curDir = this.getDirectionNumber(dx, dy);

            if (dir === curDir) {
                return;
            }
        }

        this.directionX = x;
        this.directionY = y;
    };

    // This function pushes a new segment to the front of the
    // snake. The snake is modeled as a FIFO
    s.enqueue = function(s) {
        var oldHead = this.head;
        this.head = s;
        this.head.next = oldHead;
        this.head.previous = null;
        oldHead.previous = this.head;
    };

    // This function is called whenever the snake needs to grow. Right
    // now it's only when the snake eats something
    s.grow = function() {
        this.growCount += GROW_COUNT;
    };

    // This function removes the tail segment from the snake.
    s.dequeue = function() {
        // If the snake is growing... reduce the grow count by one and
        // down't remove the tail segment from the snake
        if (this.growCount > 0) {
            this.growCount = this.growCount - 1;
            return;
        }

        var oldTail = this.tail;
        if (oldTail.previous === null) {
            console.warn("dequeue called on an empty snake");
            return oldTail;
        }

        this.tail = oldTail.previous;
        this.tail.next = null;
        return oldTail;
    };

    // This function moves the head of the snake by the specified
    // amount. The head moves in the direction last specified by
    // setDirection
    s.move = function(amount) {
        var newSeg = this.head.clone();
        newSeg.x += (this.directionX * amount);
        newSeg.y += (this.directionY * amount);
        newSeg.x = Math.round(newSeg.x / amount) * amount;
        newSeg.y = Math.round(newSeg.y / amount) * amount;

        this.enqueue(newSeg);
        this.dequeue();

        return this.checkCollision();
    };

    // This function is used determine if the snake hit
    // anything. Every step along the way the snake will check to see
    // if the head is on top of another segment or if the head is
    // positioned beyond the max dimensions of the canvas
    s.checkCollision = function() {
        var snakeLocs = this.getLocations();
        var i, len;
        len = snakeLocs.length;

        // Start at one since we want to ignore the head
        for (i = 1; i < len; i = i + 1) {
            if (this.head.x === snakeLocs[i].x && this.head.y === snakeLocs[i].y) {
                // Collisission
                return true;
            }
        }
        if (this.head.x < 0 || this.head.y < 0 || this.head.x >= this.maxX || this.head.y >= this.maxY) {
            return true;
        }
        return false;
    };

    // The snake is implemented with a linked list. This function
    // makes a copy of the snake and turns it into an array
    s.getLocations = function() {
        var spots = [];
        var seg = this.head;
        do {
            spots.push({
                x: seg.x,
                y: seg.y
            });
            seg = seg.next;
        } while (seg);
        return spots;
    };

    window.Snake = Snake;
}());


(function() {
    "use strict";
    var BACKGROUND_COLOR = "#000000";
    var SNAKE_COLOR = "#FFFF00";
    var FOOD_COLOR = "#00FF00";
    var FOOD_PIECES = 3;
    var SEGMENT_SIZE = 20;
    var SEGMENT_BORDER_SIZE = 1;

    var s;

    // This is the constructor for the renderer. This code is
    // responsible for taking the data representation of the snake,
    // and drawing it on the canvas
    function SnakeRenderer(canvas, snake) {
        this.canvas = canvas;
        this.snake = snake;
        this.foodPieces = [];
        this.init();
    }

    s = SnakeRenderer.prototype;

    // This function starts the game fresh. It clears the canvas,
    // renders the full snake, and puts the food on the board.
    s.init = function() {
        this.points = 0;
        this.drawBackground();
        this.renderFullSnake();
        for (var i = 0; i < FOOD_PIECES; i = i + 1) {
            this.renderFood();
        }
        this.updatePoints();
    };

    // This function adds a food item to the board
    s.renderFood = function() {
        var spot = this.getFoodSpot();
        this.drawSegment(spot.x, spot.y, FOOD_COLOR);
        this.foodPieces.push(spot);
        this.foodCleanUp(); // Might be unnecessary
    };

    // Food items get deleted from the array, but array deletion just
    // removes the value from the array, it does not remove that index
    // and shift the rest of the elements. This function removes empty
    // spots from the array
    s.foodCleanUp = function() {
        var food = [];
        var i, len;
        len = this.foodPieces.length;
        for (i = 0; i < len; i = i + 1) {
            if (this.foodPieces[i]) {
                food.push(this.foodPieces[i]);
            }
        }
        this.foodPieces = food;
    };

    // This is one of the most complicated functions. This decides
    // where to put food on the canvas. The way it works is it figures
    // out every possible spot where food could go, then it removes
    // all of the places where the snake is and all of the places
    // where food already exists. Then it shuffles that data and
    // returns the top spot.
    s.getFoodSpot = function() {
        var spots = [];
        var i, j;
        for (i = 0; i < this.canvas.width - SEGMENT_SIZE; i = i + SEGMENT_SIZE) {
            for (j = 0; j < this.canvas.height - SEGMENT_SIZE; j = j + SEGMENT_SIZE) {
                spots.push({
                    x: i,
                    y: j
                });
            }
        }

        this.foodCleanUp();
        var snakeLocs = this.snake.getLocations();
        snakeLocs = snakeLocs.concat(this.foodPieces);

        // Should push existing food spots here.
        var finalSpots = [];

        var curSpot;
        var overlap = false;
        for (i = 0; i < spots.length; i = i + 1) {
            curSpot = spots[i];
            overlap = false;

            for (j = 0; j < snakeLocs.length; j = j + 1) {
                if (curSpot.x === snakeLocs[j].x && curSpot.y === snakeLocs[j].y) {
                    overlap = true;
                    break;
                }
            }
            if (overlap) {
                continue;
            }
            finalSpots.push(curSpot);
        }

        finalSpots = shuffle(finalSpots);


        if (finalSpots.length === 0) {
            // game over?
            alert("Game Over");
        } else {
            return finalSpots[0];
        }

    };

    // For efficiency, we normally only draw the snake head and erase
    // the tail. The function draws the full length of the snake. This
    // is used when the game starts
    s.renderFullSnake = function() {
        var i = 0;
        var seg = this.snake.head;
        do {
            i = i + 1;
            this.drawSegment(seg.x, seg.y, SNAKE_COLOR);
            seg = seg.next;
        } while (seg);
    };

    // This renders the head of the snake
    s.renderSnakeHead = function() {
        var seg = this.snake.head;
        this.drawSegment(seg.x, seg.y, SNAKE_COLOR);
    };

    // This draws a segment at the location x,y with the color
    // provided. Right now the shape is a square, but not fully
    // necessary.
    s.drawSegment = function(x, y, color) {
        var ctx = this.canvas.getContext("2d");

        ctx.fillStyle = BACKGROUND_COLOR;
        ctx.fillRect(
            x,
            y,
            SEGMENT_SIZE,
            SEGMENT_SIZE
        );

        ctx.fillStyle = color;
        ctx.fillRect(
            x + SEGMENT_BORDER_SIZE,
            y + SEGMENT_BORDER_SIZE,
            SEGMENT_SIZE - (2 * SEGMENT_BORDER_SIZE),
            SEGMENT_SIZE - (2 * SEGMENT_BORDER_SIZE)
        );
    };


    // This function renders the full background of the game.
    s.drawBackground = function() {
        var ctx = this.canvas.getContext("2d");
        ctx.fillStyle = BACKGROUND_COLOR;
        ctx.fillRect(
            0,
            0,
            this.canvas.width,
            this.canvas.height
        );
    };

    // This function is called every 'tick' of the game.
    s.move = function() {
        var oldTail = this.snake.tail;

        if (this.snake.move(SEGMENT_SIZE)) {
            return true;
        }

        this.drawSegment(oldTail.x, oldTail.y, BACKGROUND_COLOR);
        this.checkSnakeEat();
        this.renderSnakeHead();

        return false;
    };

    // This function checks to see if the snake ate something. If it
    // did then it grows the snake and deletes the food from our
    // internal data structure.
    s.checkSnakeEat = function() {
        var len, i;
        len = this.foodPieces.length;
        for (i = 0; i < len; i = i + 1) {
            if (this.foodPieces[i].x === this.snake.head.x && this.foodPieces[i].y === this.snake.head.y) {
                this.snake.grow();
                this.points = this.points + 1;
                delete this.foodPieces[i];
                this.renderFood();
                this.updatePoints();
            }
        }
        return false;
    };

    // Whenver the snake eats something, we update the points
    s.updatePoints = function() {
        var locs = this.snake.getLocations();
        $('.segment-count').text(locs.length);
        $('.point-count').text(this.points);
    };

    // This is a convenience function for shuffing an array. I use it
    // to find the right spot to place some food.
    function shuffle(array) {
        var currentIndex = array.length,
            temporaryValue, randomIndex;

        while (0 !== currentIndex) {

            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;

            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }

        return array;
    }

    window.SnakeRenderer = SnakeRenderer;
}());

(function() {
    "use strict";
    var g;
    var GO_UP = 38;
    var GO_DOWN = 40;
    var GO_LEFT = 37;
    var GO_RIGHT = 39;
    var TICK_INTERVAL = 150;

    // This is the constructor for the GameManager this function is
    // responsible for handling events and running the actual clock
    function GameManager(canvas) {
        this.setCanvas(canvas);
        this.init();
        this.listen();
    }

    g = GameManager.prototype;


    // Simple init function that's use to get the game started
    g.init = function() {
        this.tickCount = 0;
        this.snake = new Snake(this.canvas.width, this.canvas.height);
        this.snakeRenderer = new SnakeRenderer(this.canvas, this.snake);
        this.running = false;
    };

    // When the game manager is constructed, this function is called
    // to size the canvas appropriately
    g.setCanvas = function(canvas) {
        this.canvas = canvas;
        var otherHeight = $('nav').height() + $('#instructions').height() + $('footer').height() + 60;
        console.log(otherHeight);
        this.setCanvasHeight($(window).height() - otherHeight);
        this.setCanvasWidth($(window).width());
    };

    // This sets the height onf the canvas
    g.setCanvasHeight = function(height) {
        height = Math.round(height / 10) * 10;
        this.canvas.height = height;
    };

    // This sets the width of the canvas
    g.setCanvasWidth = function(width) {
        width = Math.round(width / 10) * 10;
        this.canvas.width = width;
    };

    // This function starts the interval for the game
    g.start = function() {
        var that = this;
        this.tickIntervalHandle = window.setInterval(function() {
            if (that.running) {
                that.tick(true);
            }
        }, TICK_INTERVAL);
    };

    // This is the function that runs over and over and represents the
    // heartbeat of the game
    g.tick = function(realTick) {
        $('.tick-count').text(this.tickCount++);
        if (this.skipNext && this.snakeRenderer.move()) {
            // Game Over
            $('.modal').modal();
            this.running = false;
        }
        if (!realTick) {
            this.skipNext = false;
        } else {
            this.skipNext = true;
        }

    };

    // This function runs when the game manager is constructed. It
    // attaches listeners in order to support game play
    g.listen = function() {
        var that = this;
        $(document).keydown(function(evt) {
            switch (evt.which) {
                case GO_UP:
                    that.running = true;
                    that.snake.setDirection(0, -1);
                    that.tick(false);
                    return false;
                case GO_DOWN:
                    that.running = true;
                    that.snake.setDirection(0, 1);
                    that.tick(false);
                    return false;
                case GO_LEFT:
                    that.running = true;
                    that.snake.setDirection(-1, 0);
                    that.tick(false);
                    return false;
                case GO_RIGHT:
                    that.running = true;
                    that.snake.setDirection(1, 0);
                    that.tick(false);
                    return false;
                case 80:
                    // Pause
                    that.running = (!that.running);
                    break;
            }
        });
        $('input[type=radio]').change(function() {
            TICK_INTERVAL = parseInt($('input[type=radio]:checked').val(), 10);
            window.clearInterval(that.tickIntervalHandle);
            that.start();
            $(that.canvas).focus();
        });
        $('.reset-game').click(function() {
            that.init();
        });
    };

    window.GameManager = GameManager;
}());

$(function() {
    "use strict";
    // When the page is loaded, this code runs and it creates the game manager
    var gm = new GameManager(document.getElementById('snake-canvas'));
    gm.start();
    console.log('Loaded');
});
