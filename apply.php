<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include 'header.inc'; ?>
    <header class="job-header">
        <h1>Job Application</h1>


    </header>


    <section class="form-container">
        <form id="application-form" method="post" action="process_eoi.php">
            <h3>Job Application <br>
            </h3>
            <!-- Element hr not allowed as child of element h2 in this context. -->
            <hr>
            <table>
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Your response</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Job reference number</td>
                        <td>
                            <label for="number">Job reference number</label>
                            <select name="number" id="number" required>
                                <option value="" disabled selected>Select your reference number</option>
                                <option value="SE123">SE123</option>
                                <option value="CS789">CS789</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>First Name</td>
                        <td>
                            <label for="first-name"><em>Please enter your first name:</em></label>
                            <input type="text" name="first-name" id="first-name" maxlength="20" pattern="[a-zA-Z]+$" required>

                        </td>
                    </tr>
                    <tr>
                        <td>Last name</td>
                        <td>
                            <label for="last-name"><em>Please enter your last name:</em></label><br>
                            <input type="text" name="last-name" id="last-name" maxlength="20" pattern="[a-zA-Z]+$" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Date of birth</td>
                        <td>
                            <label for="dob"><em>Please enter your birthday:</em></label><br>
                            <input type="date" name="dob" id="dob" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>
                            <fieldset>
                                <legend>Please select your gender:</legend>

                                <input type="radio" id="gender-m" name="gender" value="m" required>
                                <label for="gender-m">Male</label>

                                <input type="radio" id="gender-f" name="gender" value="f">
                                <label for="gender-f">Female</label>

                                <input type="radio" id="gender-o" name="gender" value="o">
                                <label for="gender-o">Other</label>

                                <input type="radio" id="gender-p" name="gender" value="p">
                                <label for="gender-p">Prefer not to say</label>
                            </fieldset>

                        </td>
                    </tr>
                    <tr>
                        <td>Street Address</td>
                        <td>
                            <label for="address"><em>Please enter your address:</em></label><br>
                            <input type="text" name="address" id="address" maxlength="40" required>
                        </td>

                    </tr>
                    <tr>
                        <td>Suburb/Town</td>
                        <td>
                            <label for="suburb"><em>Please enter your suburb/town:</em></label><br>
                            <input type="text" name="suburb" id="suburb" maxlength="40" required>
                        </td>

                    </tr>
                    <tr>
                        <td>State</td>
                        <td>
                            <label for="state">State</label><br>
                            <select name="state" id="state" required>
                                <option value="" disabled selected>Select your state</option>
                                <option value="VIC">VIC</option>
                                <option value="NSW">NSW</option>
                                <option value="QLD">QLD</option>
                                <option value="NT">NT</option>
                                <option value="SA">SA</option>
                                <option value="TAS">TAS</option>
                                <option value="ACT">ACT</option>
                            </select>

                        </td>
                    </tr>
                    <tr>
                        <td>Postcode</td>
                        <td>
                            <label for="postcode"><em>Please enter your postcode:</em></label><br>
                            <input type="text" name="postcode" id="postcode" pattern="\d{4}" required>
                        </td>

                    </tr>
                    <tr>
                        <td>Email address</td>
                            <td>
                            <label for="email"><em>Please enter your email:</em></label><br>
                            <input type="email" name="email" id="email" placeholder="name@example.com" required>
                            </td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td>
                            <label for="phone"><em>Please enter your phone number:</em></label><br>
                            <input type="tel" id="phone" name="phone" pattern="[\d\s]{8,12}" required>
                        </td>


                    </tr>

                    <tr>
                        <td>Required Technical List</td>
                        <td>
                        <fieldset>
                            <legend>Technical Skills</legend>

                            <input type="checkbox" id="tech-nws" name="technical_skills[]" value="NWS">
                            <label for="tech-nws">Network Security</label>

                            <input type="checkbox" id="tech-eps" name="technical_skills[]" value="EPS">
                            <label for="tech-eps">Endpoint Security</label><br>

                            <input type="checkbox" id="tech-aps" name="technical_skills[]" value="APS">
                            <label for="tech-aps">Application Security</label>

                            <input type="checkbox" id="tech-eth" name="technical_skills[]" value="ETH">
                            <label for="tech-eth">Ethical Hacking</label><br>

                            <input type="checkbox" id="tech-thh" name="technical_skills[]" value="THH">
                            <label for="tech-thh">Threat Hunting</label>
                        </fieldset>
                        </td>

                    </tr>

                    <tr>
                        <td>Other Skills</td>
                        <td>
                            <label for="other_skills"><em>Please enter any other related skills:</em></label><br>
                            <textarea id="other_skills" name="other_skills" rows="4" cols="40" style="resize: none;" placeholder="e.g., cloud computing, scripting languages, DevOps tools"></textarea>
                        </td>


                    </tr>

                </tbody>
            </table>
            <button type="submit">Apply</button>
        </form>
    </section>






    <?php include 'footer.inc'; ?>



</body>

</html>