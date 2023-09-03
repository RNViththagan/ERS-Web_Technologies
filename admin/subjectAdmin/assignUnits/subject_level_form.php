<link rel="stylesheet" href="subjectAdmin/assignUnits/assignunit.css">

<h1>Subject Selection Form</h1>
<div class="exam-info">
    <h4>Exam : <?php echo $curExam['academic_year']." semester". $curExam['semester']; ?></h4>
</div>
<?php
if (isset($msg['error'])) {
    echo '<div class="error-message">' . $msg['error'] . '</div>';
}

if (isset($msg['success'])) {
    echo '<div class="success-message">' . $msg['success'] . '</div>';
}
?>
<form id="assignment-form" action="" method="POST">
    <input type="hidden" name="exam_id" value="<?php  echo $curExam['exam_id']?>">
    <!-- Part 1: Selection -->
    <label for="level">Select Level:</label>
    <select id="level" name="level">
        <option value="" disabled selected>Select Level</option>
        <option value="1">Level 1</option>
        <option value="2">Level 2</option>
        <option value="3">Level 3</option>
        <option value="4">Level 4</option>
    </select>

    <label for="subject">Select Subject:</label>
    <select id="subject" name="subject">
        <option value="" disabled selected>Select Subject</option>
        <!-- Populate subjects dynamically based on data -->
    </select>

    <label for="type">Select Type:</label>
    <select id="type" name="type">
        <option value="" disabled selected>Select Type</option>
        <option value="Proper">Proper</option>
        <option value="Repeat">Repeat</option>
    </select>

    <button type="button" class="form-btn" id="assign-button">Assign Units</button>
    <div id="msgDiv"></div>
    <!-- Part 2: Dynamic Unit Assignment -->
    <div id="unit-assignment-container" style="display: none;">
        <div id="unit-assignment"></div>
        <button id="add-unit" type="button">Add Unit</button>
    </div>

    <!-- Part 3: Buttons -->
    <button type="button" class="form-btn" id="submit-button" style="display: none;">Submit</button>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get references to DOM elements
        var assignmentForm = document.getElementById("assignment-form");
        var levelSelect = document.getElementById("level");
        var subjectSelect = document.getElementById("subject");
        var typeSelect = document.getElementById("type");
        var assignButton = document.getElementById("assign-button");
        var submitButton = document.getElementById("submit-button");
        var messageDiv = document.getElementById("msgDiv");

        var addUnitButton = document.getElementById("add-unit");
        var unitAssignment = document.getElementById("unit-assignment");
        var unitAssignmentContainer = document.getElementById("unit-assignment-container");
        var currentUnitDropdowns = 1; // Track the current number of unit dropdowns
        var maxUnitDropdowns = 0; // Store the maximum number of unit dropdowns based on available units


        var subjectsData = [];
        var unitsData = [];

        // Function to fetch units data from the server
        function fetchSubjectsData() {
            var exam_id = 1;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "subjectAdmin/assignUnits/get_subjects.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    subjectsData = JSON.parse(xhr.responseText);
                    addSubjectDropdown();
                }
            };

            var formData = "exam_id=" + exam_id;
            xhr.send(formData);
        }

        // Call the fetchSubjectsData function when the page loads
        fetchSubjectsData();

        // Function to add a subject dropdown
        function addSubjectDropdown() {
            // Populate the subject dropdown with the stored data
            subjectSelect.innerHTML = `
        <option value="" disabled selected>Select Subject</option>`;
            for (var i = 0; i < subjectsData.length; i++) {
                subjectSelect.innerHTML += `
            <option value="${subjectsData[i].subject}">${subjectsData[i].subject}</option>`;
            }
        }

        // Function to handle form submission for "Assign Units" button
        function handleAssignUnitsFormSubmission() {
            var isFormValid = true;

            // Check if Level is selected
            if (levelSelect.value === "") {
                isFormValid = false;
                alert("Please select a Level.");
                return;
            }

            // Check if Subject is selected
            if (subjectSelect.value === "") {
                isFormValid = false;
                alert("Please select a Subject.");
                return;
            }

            // Check if Type is selected
            if (typeSelect.value === "") {
                isFormValid = false;
                alert("Please select a Type.");
                return;
            }

            if (isFormValid) {
                // Disable the form and button
                levelSelect.disabled = true;
                subjectSelect.disabled = true;
                typeSelect.disabled = true;

                // Display a message
                messageDiv.textContent = "Form submitted.";

                // Call the fetchUnitsData function when the page loads
                fetchUnitsData();

                // Change the button text to "Edit"
                assignButton.textContent = "Edit";
                assignButton.removeEventListener("click", handleAssignUnitsFormSubmission);
                assignButton.addEventListener("click", handleEditClick);
            }
        }

        // Function to handle "Edit" button click
        function handleEditClick() {
            // Enable the form elements
            assignButton.textContent = "Assign Units";
            assignButton.removeEventListener("click", handleEditClick);
            assignButton.addEventListener("click", handleAssignUnitsFormSubmission);
            assignButton.disabled = false;
            levelSelect.disabled = false;
            subjectSelect.disabled = false;
            typeSelect.disabled = false;
            messageDiv.textContent = "";
            // Hide the "Submit" button
            submitButton.style.display = "none";

            // Reset dropdown count
            currentUnitDropdowns = 1;
            maxUnitDropdowns = 0;

            // Clear previously generated unit selectors
            unitAssignment.innerHTML = "";

            // Hide the unit assignment container
            unitAssignmentContainer.style.display = "none";
        }


        // Function to fetch units data from the server
        function fetchUnitsData() {
            var selectedSubject = document.getElementById("subject").value;
            var selectedLevel = document.getElementById("level").value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "subjectAdmin/assignUnits/get_units.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    unitsData = JSON.parse(xhr.responseText);
                    maxUnitDropdowns = unitsData.length; // Update the maximum based on available units

                    if (unitsData.length === 0) {
                        // No units available, display a message
                        unitAssignmentContainer.style.display = "none";
                        // Hide the "Submit" button
                        submitButton.style.display = "none";
                        messageDiv.textContent = "No units available for the selected subject and level.";
                    } else {
                        // Show the "Submit" button
                        submitButton.style.display = "block";
                        // Units available, add unit dropdowns
                        unitAssignmentContainer.style.display = "block";
                        addUnitDropdown();
                    }
                }
            };

            var formData = "subject=" + selectedSubject + "&level=" + selectedLevel;
            xhr.send(formData);
        }

        // Function to add a unit dropdown with a remove button
        function addUnitDropdown() {
            var unitDropdown = document.createElement("select");
            unitDropdown.name = "unit_subjects[]";

            // Populate the unit dropdown with the stored data
            unitDropdown.innerHTML = `
        <option value="" disabled selected>Select Unit</option>`;
            for (var i = 0; i < unitsData.length; i++) {
                unitDropdown.innerHTML += `
            <option value="${unitsData[i].unitId}">${unitsData[i].unitCode} ${unitsData[i].name} (${unitsData[i].acYearAdded})</option>`;
            }

            var removeButton = document.createElement("button");
            removeButton.className = "remove-unit";
            removeButton.type = "button";
            removeButton.textContent = "Remove";

            var unitDiv = document.createElement("div");
            unitDiv.className = "unit-dropdown";
            unitDiv.appendChild(unitDropdown);
            unitDiv.appendChild(removeButton);

            unitAssignment.appendChild(unitDiv);

            // Attach a click event handler to the remove button
            removeButton.addEventListener("click", function () {
                unitAssignment.removeChild(unitDiv);
                currentUnitDropdowns--;
            });
        }

        // Function to handle "Add Unit" button click
        function handleAddUnitClick() {
            if (currentUnitDropdowns < maxUnitDropdowns) {
                addUnitDropdown();
                currentUnitDropdowns++;
            } else {
                // You can show a message or disable the button here to indicate the limit
                alert("You've reached the maximum number of unit dropdowns.");
            }
            console.log(maxUnitDropdowns+" " +currentUnitDropdowns);
        }

        // Attach click event handler to the "Add Unit" button
        addUnitButton.addEventListener("click", handleAddUnitClick);

        // Function to handle form submission for "Submit" button
        function handleSubmitButtonClick(event) {
            // Enable the form elements
            assignButton.disabled = false;
            levelSelect.disabled = false;
            subjectSelect.disabled = false;
            typeSelect.disabled = false;

            // Remove the message
            messageDiv.textContent = "";

            // Submit the form
            var unitSubjectSelects = document.querySelectorAll('select[name="unit_subjects[]"]');
            var isValid = true;

            // Check if at least one unit or subject is selected
            for (var i = 0; i < unitSubjectSelects.length; i++) {
                if (unitSubjectSelects[i].value === "") {
                    isValid = false; // At least one dropdown is empty
                    break;
                }
            }

            if (!isValid) {
                alert("Please select all units.");
            } else {
                assignmentForm.submit();
            }
        }

        // Attach click event handlers to the buttons
        assignButton.addEventListener("click", handleAssignUnitsFormSubmission);
        submitButton.addEventListener("click", handleSubmitButtonClick);
    });
</script>

