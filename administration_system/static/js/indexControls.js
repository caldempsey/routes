/*Uses jQuery to control index search function
* Author: Callum Dempsey Leach b6070824
* */
$(document).ready(function () {
    $(function () {
        $('#datetimepicker').datetimepicker({
            inline: true
        });
    });
    //Updates when clicking the Search Button
    $("#searchButton").click(function() {
        //Get the value of the origin station selection.
        var origin;
        origin = $("#originStation").val();
        //Get the value of the destination station selection.
        var destination;
        destination = $("#destinationStation").val();
        //Get moment object.
        var moment = $('#datetimepicker').data("DateTimePicker").date();
        //Get date from moment object.
        var date = moment.format("DDMMYY");
        //Get time from moment object.
        var time = moment.format("HHmm");
        //Get time from moment object.
        searchRoutes(origin, destination, date, time)
    });
    function searchRoutes(originStationMnemonic, destinationStationMnemonic, date, time) {
        //If the input station mnemonic is not null and the destination station mnemonic is not null and there exists a date and time.
        if (originStationMnemonic !== "" && destinationStationMnemonic !== "" && date !== null && time !== null) {
            if ((originStationMnemonic !== destinationStationMnemonic)) {
                window.location = 'routes/routes.php?' + originStationMnemonic + "/" + destinationStationMnemonic + "/" + date + "/" + time;
            } else {
                window.alert("Please choose two seperate stations.");
            }
        }
    }
});