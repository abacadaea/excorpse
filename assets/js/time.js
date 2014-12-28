//Timer
function Timer (end)
{
    this.length = length;
    this.endTime = end;
}

Timer.LENGTH_MILLISECONDS = 60 * 1000;
Timer.pad = function (seconds)
{
    return (seconds < 10 ? '0' + seconds : '' + seconds);
}
Timer.prototype.getTimeRemaining = function ()
{
    var now = (new Date ()).valueOf ();
    this.milliseconds = this.endTime - now;

    return this.endTime - now;
}

Timer.prototype.updateTimer = function ()
{
    this.getTimeRemaining ();

    this.minutes = Math.floor (this.milliseconds / 1000 / 60);
    this.seconds = Math.floor (this.milliseconds / 1000 % 60);

    if (this.milliseconds < 0)
	this.milliseconds = this.seconds = this.minutes = 0;
}
Timer.prototype.toString = function ()
{
    return '' + this.minutes + ':' + Timer.pad (this.seconds);
}


//Display Timer
function DisplayTimer (id, end) 
{
    Timer.call (this, end);
    this.id = id;
    console.log ('Timer initialized');
}

DisplayTimer.prototype = new Timer ();
DisplayTimer.INTERVAL = 100;

DisplayTimer.prototype.display = function ()
{
    //$ ('#' + this.id).html (this.toString ());
    if (this.timerText != null)
	this.timerText.remove ();
    var fill = (this.seconds <= 15 ? "#f00" : "#000");

    $('#id').html (this.toString ());
    $('#id').css ("color", fill);
}
DisplayTimer.prototype.updateTimer = function ()
{
    Timer.prototype.updateTimer.call (this);
    this.display ();
}
DisplayTimer.startTimer = function (timer)
{
    timer.interval = setInterval (function () {timer.updateTimer ();}, DisplayTimer.INTERVAL);
}
