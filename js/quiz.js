var pos = 0, test, test_status, question, choice, choices, chA, chB, chC, correct = 0;
var questions = [
    ["What is 10 + 4?", "19", "14", "16", "B"],
    ["What is 23 - 9?", "15", "19", "14", "C"],
    ["What is 4 + 7?", "13", "15", "11", "C"],
    ["What is 2 + 7?", "15", "9", "10", "B"]
];

function getElem(x){
    return document.getElementById(x);
}

function renderQuestion(){
    test = getElem("test");
    //check if position is greater than amount of questions
    if(pos >= questions.length){
        test.innerHTML = "<h2>You got "+correct+" of "+questions.length+" questions correct.</h2>";
        getElem("test_status").innerHTML = "Test Completed";
        // reset variables to default
        pos = 0;
        correct = 0;
        //stops function executing any further
        return false;
    }
    getElem("test_status").innerHTML = "Question "+(pos+1)+" of "+questions.length;
    question = questions[pos][0];
    chA = questions[pos][1];
    chB = questions[pos][2];
    chC = questions[pos][3];
    test.innerHTML = "<h3>"+question+"</h3>";
    test.innerHTML += "<input type='radio' name='choices' value='A'> "+chA+"<br>";
    test.innerHTML += "<input type='radio' name='choices' value='B'> "+chB+"<br>";
    test.innerHTML += "<input type='radio' name='choices' value='C'> "+chC+"<br>";
    test.innerHTML += "<button onclick='checkAnswer()'>Submit Answer</button>";
}

function checkAnswer() {
    choices = document.getElementsByName("choices");
    for(var i=0; i<choices.length; i++){
        if(choices[i].checked){
            choice = choices[i].value;
        }
    }
    //to add question results after submit render it here and use and else statement
    // if it its wrong. 15:40
    if(choice == questions[pos][4]){
        correct++;
    }
    pos++;
    renderQuestion();
}

window.addEventListener("load", renderQuestion, false);