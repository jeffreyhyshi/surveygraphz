
//results =  

containers = [];

$(function(){
    results = $.parseJSON($("#surveyquestions").val());
    

    for(var j = 0; j < results.length; j++){
        //populate containers with the SVG graphics containers, one per question in the survey
        containers.push(d3.select("body").insert("svg", "#footer")
        .attr("width", 500)
        .attr("height", 430)
        .attr("id", function(d, i){return "container".concat(j)})
        .attr("class", "graph")
        .style("display", "block")
        .style("margin-bottom", "19px")
        .style("margin-left", "auto")
        .style("margin-right", "auto")
        .style("border", "1px solid #EEEEEE"));
        //label SVG graphics containers
        d3.select("body").insert("h4", function(){
            return document.getElementById("container"+j);
        })
        .text((j+1) + ". " + results[j].question)
        .style("font-family", "sans-serif")
        .style("text-decoration", "none")
        .style("font-size", "15px");
    }
    drawBarCharts();
});

function drawBarCharts(){
    for(var j = 0; j < containers.length; j++){
        //draw bars
        var yscalar = yscale(results[j].responses);
        var xscalar = xscale(results[j].responses);
        containers[j].selectAll("rect").data(results[j].responses).enter().append("rect")
        .attr("width", 0.8*xscalar)
        .attr("y", 355)
        .attr("height", 0)
        .style("fill", "#000000")
        .transition()
        .duration(1250)
        .attr("y", function(d, i){return 355 - yscalar*d})
        .attr("height", function(d, i){return yscalar*d})
        .attr("x", function(d, i){return 50+0.1*xscalar+xscalar*i})
        .style("fill", "steelblue");
        //draw axes
        containers[j].selectAll("line").data([0, 1]).enter().append("line")
        .attr("x1", 45)
        .attr("y1", function(d, i){if(i===0){return 5;} return 355;})
        .attr("x2", 45)
        .attr("y2", function(d, i){if(i===0){return 5;} return 355;})
        .transition()
        .duration(1250)
        .attr("x2", function(d, i){if(i===0){return 45;} return 495;})
        .attr("y2", 355)
        .style("stroke", "#000000")
        .style("stroke-width", "2px");
        //draw text
        var yAxisTitle = "Number of Responses";
        var yUpperLabel = results[j].responses[0];
        for(var k = 0; k < results[j].responses.length; k++){
            if(results[j].responses[k]===NaN){
                console.log("NaN error");
                break;
            }
            if(results[j].responses[k] > yUpperLabel){
                yUpperLabel = results[j].responses[k];
            }
        }
        var yLowerLabel = 0;
        var textData = [yAxisTitle, yUpperLabel, yLowerLabel].concat(results[j].choices);
        containers[j].selectAll("text").data(textData).enter().append("text")
        .attr("x", function(d, i){
            if(i===0){
                return -243;
            }
            if(i===1){
                return 10;
            }
            if(i===2){
                return 10;
            }
            else {
                return -360;
            }
        })
        .attr("y", function(d, i){
            if(i===0){
                return 15;
            }
            if(i===1){
                return 15;
            }
            if(i===2){
                return 355;
            }
            else {
                return 50-2.47*xscalar+xscalar*i;
            }
        })
        .text(function(d, i){return d;})
        .attr("transform", function(d, i){
            if(i===0 || i>=3){
                return "rotate(-90 0, 0)";
            } else {
                return;
            }
        })
        .attr("text-anchor", function(d, i){
            if(i>2){
                return "end";
            }
            return "start";
        })
        .attr("font-family", "sans-serif")
        .style("opacity", 0)
        .attr("font-size", "14px")
        .transition()
        .duration(1250)
        .style("opacity", 1);
    }
}

function drawPieCharts(){
    for(var j = 0; j < containers.length; j++){

    }
}

function yscale(arr){
    var largestInt = arr[0];
    for(var i = 0; i < arr.length; i++){
        if(arr[i]===NaN){
            return;
        }
        if(arr[i] > largestInt){
            largestInt = arr[i];
        }
    }
    if(largestInt===0){
        return;
    }
    return 350/largestInt;
}

function xscale(arr){
    if(arr.length===0){
        return;
    }
    return 450/(arr.length);
}
