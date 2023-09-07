<?php
$msg = array();
if (isset($_POST['unit_subjects'])) {
    $exam_id = $_POST['exam_id'];
    $level = $_POST['level'];
    $subject = $_POST['subject'];
    $type = $_POST['type'];
    $unit_subjects = $_POST['unit_subjects'];

    $delete_query = "DELETE FROM `unit_sub_exam`
                            WHERE exam_unit_id IN (
                                            SELECT `unit_sub_exam`.`exam_unit_id`
                                FROM `unit_sub_exam`
                                LEFT JOIN `unit` ON `unit_sub_exam`.`unitId` = `unit`.`unitId`
                                WHERE unit_sub_exam.exam_id = $exam_id
                                        AND subject = '$subject'
                                        AND type = '$type'
                                AND level = '$level'
                            );";

    if (!mysqli_query($con, $delete_query)) {
        $msg['error'] = "Error deleting units: " . mysqli_error($con);
    }

    $assignQuery = "INSERT INTO `unit_sub_exam` (`exam_id`, `unitId`, `type`) VALUES ";
    $fst = true;
    foreach ($unit_subjects as $unit) {
        $assignQuery .= ($fst) ? $fst = false : ", ";
        $assignQuery .= "($exam_id, $unit, '$type')";
    }

    if (!mysqli_query($con, $assignQuery)) {
        $msg['error'] = "Error assigning units: " . mysqli_error($con);
    } else {
        $msg['success'] = "Units assigned successfully.";
    }
}
?>



<div class="flex flex-col items-center justify-around gap-5">
    <h1 class="title">Subject Selection Form</h1>
    <h4 class="text-gray-800">Exam : <?php echo $curExam['academic_year'] . " semester" . $curExam['semester']; ?></h4>

    <?php
    if (isset($msg['error'])) {
        echo '<div class="text-red-500">' . $msg['error'] . '</div>';
    }

    if (isset($msg['success'])) {
        echo '<div class="text-green-500">' . $msg['success'] . '</div>';
    }
    ?>

    <form id="assignment-form" action="" method="POST" class="flex flex-col items-center gap-5 mt-5">
        <input type="hidden" name="exam_id" id="exam_id" value="<?php echo $curExam['exam_id'] ?>">
        <!-- Part 1: Selection -->
        <div class="w-full grid grid-cols-3 gap-4 items-center h-8">
            <label for="level">Select Level:</label>
            <select id="level" name="level" class="col-span-2 w-full h-full border border-gray-400 rounded-full px-5 outline-none focus:border-blue-500">
                <option value="" disabled selected>Select Level</option>
                <option value="1">Level 1</option>
                <option value="2">Level 2</option>
                <option value="3">Level 3</option>
                <option value="4">Level 4</option>
            </select>
        </div>

        <div class="w-full grid grid-cols-3 gap-4 items-center h-8">
            <label for="subject">Select Subject:</label>
            <select id="subject" name="subject" class="col-span-2 w-full h-full border border-gray-400 rounded-full px-5 outline-none focus:border-blue-500">
                <option value="" disabled selected>Select Subject</option>
                <!-- Populate subjects dynamically based on data -->
            </select>
        </div>

        <div class="w-full grid grid-cols-3 gap-4 items-center h-8">
            <label for="type">Select Type:</label>
            <select id="type" name="type" class="col-span-2 w-full h-full border border-gray-400 rounded-full px-5 outline-none focus:border-blue-500">
                <option value="" disabled selected>Select Type</option>
                <option value="Proper">Proper</option>
                <option value="Repeat">Repeat</option>
            </select>
        </div>

        <button type="button" class="btn fill-btn mt-4" id="assign-button">Assign Units</button>
        <div id="msgDiv"></div>
        <!-- Part 2: Dynamic Unit Assignment -->
        <div id="unit-assignment-container" style="display: none;" class="mt-5 flex flex-col items-center justify-around gap-4">
            <div id="unit-assignment"></div>
            <button id="add-unit" type="button" class="btn outline-btn !py-1 !px-4 mt-2">Add Unit</button>
        </div>

        <!-- Part 3: Buttons -->
        <button type="button" class="btn fill-btn" id="submit-button" style="display: none;">Submit</button>
    </form>
</div>

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
            var currentUnitDropdowns = 0; // Track the current number of unit dropdowns
            var maxUnitDropdowns = 0; // Store the maximum number of unit dropdowns based on available units

            var exam_id = document.getElementById("exam_id").value; // Get the exam_id

            var subjectsData = [];
            var unitsData = [];

            // Function to fetch units data from the server
            function fetchSubjectsData() {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "subjectAdmin/assignUnits/get_subjects.php", false);
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

                    // Call the fetchUnitsData function when the page loads
                    fetchUnitsData();

                    // Fetch already assigned units
                    fetchAssignedUnits(); // Add this line

                    if (currentUnitDropdowns === 0) {
                        addUnitDropdown(null);
                    }

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
                currentUnitDropdowns = 0;
                maxUnitDropdowns = 0;

                // Clear previously generated unit selectors
                unitAssignment.innerHTML = "";

                // Hide the unit assignment container
                unitAssignmentContainer.style.display = "none";
            }

            // Function to fetch already assigned units
            function fetchAssignedUnits() {
                var selectedSubject = document.getElementById("subject").value;
                var selectedLevel = document.getElementById("level").value;
                var selectedType = document.getElementById("type").value;

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "subjectAdmin/assignUnits/get_assigned_units.php", false);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var assignedUnits = JSON.parse(xhr.responseText);
                        if (assignedUnits.length > 0) {
                            // Units are already assigned, generate dropdowns
                            unitAssignmentContainer.style.display = "block";
                            addAssignedUnitDropdowns(assignedUnits);
                            // Display a message
                            messageDiv.textContent = "Existing assigned units found.";
                        }
                    }
                };

                var formData = "exam_id=" + exam_id + "&subject=" + selectedSubject + "&level=" + selectedLevel + "&type=" + selectedType;
                xhr.send(formData);
            }

            // Function to add assigned unit dropdowns
            function addAssignedUnitDropdowns(assignedUnits) {
                for (var i = 0; i < assignedUnits.length; i++) {
                    var unitId = assignedUnits[i].unitId;
                    addUnitDropdown(unitId);
                }
            }

            // Function to fetch units data from the server
            function fetchUnitsData() {
                var selectedSubject = document.getElementById("subject").value;
                var selectedLevel = document.getElementById("level").value;

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "subjectAdmin/assignUnits/get_units.php", false);
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
                        }
                    }
                };

                var formData = "subject=" + selectedSubject + "&level=" + selectedLevel;
                xhr.send(formData);
            }

            // Function to add a unit dropdown with a remove button
            function addUnitDropdown(unitId) {
                var unitDropdown = document.createElement("select");
                unitDropdown.name = "unit_subjects[]";
                unitDropdown.className = "col-span-2 border border-gray-400 rounded-full my-2 py-1 px-5 outline-none focus:border-blue-500";

                // Populate the unit dropdown with the stored data
                unitDropdown.innerHTML = `
        <option value="" disabled selected>Select Unit</option>`;
                for (var i = 0; i < unitsData.length; i++) {
                    var selVal = (unitId === unitsData[i].unitId) ? "selected" : "";
                    unitDropdown.innerHTML += `
            <option value="${unitsData[i].unitId}" ${selVal}>${unitsData[i].unitCode} ${unitsData[i].name} (${unitsData[i].acYearAdded})</option>`;
                }

                var removeButton = document.createElement("button");
                removeButton.className = "btn outline-btn !py-1 !px-4 ml-5 my-2";
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
                // Increment the current unit dropdown count
                currentUnitDropdowns++;
            }

            // Function to handle "Add Unit" button click
            function handleAddUnitClick() {
                if (currentUnitDropdowns < maxUnitDropdowns) {
                    addUnitDropdown(null);
                } else {
                    // You can show a message or disable the button here to indicate the limit
                    alert("You've reached the maximum number of unit dropdowns.");
                }
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
                        alert("Please select all units.");
                        break;
                    }
                }

                isValid = validateDuplicateSubjects();

                if (isValid) {
                    assignmentForm.submit();
                }
            }

            // Function to validate duplicate selected subjects
            function validateDuplicateSubjects() {
                var unitSubjectSelects = document.querySelectorAll('select[name="unit_subjects[]"]');
                var selectedSubjects = [];

                // Iterate through the selected subjects and add them to the array
                for (var i = 0; i < unitSubjectSelects.length; i++) {
                    var selectedSubject = unitSubjectSelects[i].value;
                    if (selectedSubject !== "") {
                        if (selectedSubjects.includes(selectedSubject)) {
                            // Duplicate subject found, display an error message
                            alert("Duplicate selected subjects are not allowed.");
                            return false; // Prevent form submission
                        }
                        selectedSubjects.push(selectedSubject);
                    }
                }

                return true; // No duplicates found, allow form submission
            }

            // Attach click event handlers to the buttons
            assignButton.addEventListener("click", handleAssignUnitsFormSubmission);
            submitButton.addEventListener("click", handleSubmitButtonClick);
        });
    </script>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

