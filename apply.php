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
        <form id="application-form" method="post" action=" https://mercury.swin.edu.au/it000000/formtest.php">
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
                            <select name="number" id="number" required="required">
                                <option value="" disabled selected>Select your reference number</option>
                                <option value="SE123">SE123</option>
                                <option value="CS789">CS789</option>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>First Name</td>
                        <td>
                            <label><em>Please enter your first name:</em><input type="text" name="first-name" id="first-name"
                                    maxlength="20" pattern="[a-zA-Z]+$" required></label>
                        </td>
                    </tr>
                    <tr>
                        <td>Last name</td>
                        <td>
                            <Label><em>Please enter your last name:</em><input type="text" name="last-name" id="last-name"
                                    maxlength="20" pattern="[a-zA-Z]+$" required></Label>
                        </td>
                    </tr>
                    <tr>
                        <td>Date of birth</td>
                        <td><label><em>Please enter your birthday:</em><input type="text" name="dob" id="dob" maxlength="10"
                                    placeholder="dd/mm/yyyy" pattern="\d{1,2}/\d{1,2}/\d{4}" required></label></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>
                            <fieldset>
                                <legend>Please select your gender:</legend>
                                <label><input type="radio" name="gender" value="m" required> Male</label>
                                <label><input type="radio" name="gender" value="f"> Female</label>
                                <label><input type="radio" name="gender" value="o"> Other</label>
                                <label><input type="radio" name="gender" value="p"> Prefer not to say</label>

                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td>Street Address</td>
                        <td><label><em>Please enter your address:</em><input type="text" name="address" id="address"
                                    maxlength="40" required></label></td>
                    </tr>
                    <tr>
                        <td>Suburb/Town</td>
                        <td><label><em>Please enter your suburb/town:</em><input type="text" name="suburb" id="suburb"
                                    maxlength="40" required></label></td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td>
                            <select name="state" id="state" required="required">
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
                        <td><label><em>Please enter your postcode:</em><input type="text" name="postcode" id="postcode"
                                    pattern="\d{4}" required></label></td>
                    </tr>
                    <tr>
                        <td>Email address</td>
                        <td><label><em>Please enter your email:</em><input type="email" name="email" id="email"
                                    placeholder="name@example.com" required></label></td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td><label><em>Please enter your phone number:</em><br><input type="tel" name="phone"
                                     pattern="[\d\s]{8,12}" required>
                            </label>
                        </td>

                    </tr>

                    <tr>
                        <td>Required Technical List</td>

                        <td>
                            <label><input type="checkbox" name="technical skills[]" value="NWS" required>Network
                                Security</label>
                            <label><input type="checkbox" name="technical skills[]" value="EPS">Endpoint
                                Security</label><br>
                            <label><input type="checkbox" name="technical skills[]" value="APS">Application
                                Security</label>
                            <label><input type="checkbox" name="technical skills[]" value="ETH">Ethical
                                Hacking</label><br>
                            <label><input type="checkbox" name="technical skills[]" value="THH">Threat Hunting
                            </label>

                        </td>
                    </tr>

                    <tr>
                        <td>Other Skills</td>
                        <td><label><em>Please enter any other related skills:</em><textarea style="resize: none;"
                                    name="other skills" rows="4" cols="40">
                        </textarea></label></td>

                    </tr>

                </tbody>
            </table>
            <button type="submit">Apply</button>
        </form>
    </section>






    <?php include 'footer.inc'; ?>



</body>

</html>