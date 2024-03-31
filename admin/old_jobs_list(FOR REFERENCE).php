 <table id="jobsTable" class="table text-center table-hover bg-white border">
                        <thead class="bg-danger">
                            <tr>
                                <th class="bg-danger text-white">Priority</th>
                                <th class="bg-danger text-white">Position</th>
                                <th class="bg-danger text-white">Salary (Php)</th>
                                <th class="bg-danger text-white">Job Type</th>
                                <th class="bg-danger text-white">Shift & Schedule</th>
                                <th class="bg-danger text-white">Location</th>
                                <th class="bg-danger text-white">Department</th>
                                <th class="bg-danger text-white">Job Description</th>
                                <th class="bg-danger text-white">Benefits</th>
                                <th class="bg-danger text-white">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                            <tr>
                                                <td>
                                                    <?php echo $row['priority'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['job_name'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['salary'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['job_type'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['shift_and_schedule'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['location'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['department'] ?>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary badge " data-bs-toggle="modal"
                                                        data-bs-target="#seeDetailsModal<?php echo $row['id'] ?>">
                                                        See Details
                                                    </button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success badge" data-bs-toggle="modal"
                                                        data-bs-target="#seeBenefitsModal<?php echo $row['id'] ?>">
                                                        See Benefits
                                                    </button>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="User Actions">
                                                        <!-- Edit button -->
                                                        <form>
                                                            <button type="button" class="btn text-primary" data-bs-toggle="modal"
                                                                data-bs-target="#editJobModal<?php echo $row['id'] ?>">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </button>
                                                        </form>
                                                        <!-- Delete button -->
                                                        <form id="deleteJobForm<?php echo $row['id'] ?>" action="jobs_list_process.php"
                                                            method="post">
                                                            <input type="hidden" name="delete_job_id" value="<?php echo $row['id']; ?>">
                                                            <button type="button" class="btn text-danger"
                                                                onclick="confirmDelete(<?php echo $row['id']; ?>)">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- MODALS HERE -->

                                            <!-- See Details Modal -->
                                            <div class="modal fade" tabindex="-1" role="dialog"
                                                id="seeDetailsModal<?php echo $row['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content rounded-4 shadow">
                                                        <div class="modal-header p-5 pb-4 border-bottom-0">
                                                            <h1 class="fw-bold mb-0 fs-2">Job Description</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body p-5 pt-0">
                                                            <p>
                                                                <?php echo $row['job_description']; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- See Benefits Modal -->
                                            <div class="modal fade" tabindex="-1" role="dialog"
                                                id="seeBenefitsModal<?php echo $row['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content rounded-4 shadow">
                                                        <div class="modal-header p-5 pb-4 border-bottom-0">
                                                            <h1 class="fw-bold mb-0 fs-2">Benefits</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body p-5 pt-0">
                                                            <p>
                                                                <?php echo $row['benefits']; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Edit Job Modal -->
                                            <div class="modal fade" tabindex="-1" role="dialog"
                                                id="editJobModal<?php echo $row['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog " role="document">
                                                    <div class="modal-content rounded-4 shadow">
                                                        <div class="modal-header p-5 pb-4 border-bottom-0">
                                                            <h1 class="fw-bold mb-0 fs-2">Edit Job</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body p-5 pt-0">
                                                            <form action="jobs_list_process.php" method="POST">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <input type="hidden" name="jobId"
                                                                            value="<?php echo $row['id'] ?>">
                                                                        <div class="col">
                                                                            <div class="form-floating mb-2">
                                                                                <input type="text" class="form-control"
                                                                                    id="floatingInput" placeholder="Ex. Tech Support"
                                                                                    name="jobName"
                                                                                    value="<?php echo $row['job_name'] ?>" required>
                                                                                <label for="floatingInput"
                                                                                    class="form-label">Position</label>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="form-floating mb-2">
                                                                                <input type="text" class="form-control" id="salary"
                                                                                    placeholder="Ex. 15000" name="salary"
                                                                                    value="<?php echo $row['salary'] ?>" required>
                                                                                <label for="salary" class="form-label">Salary
                                                                                    (Php)</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="form-floating">
                                                                                <select class="form-select" name="priority"
                                                                                    id="priority" required>
                                                                                    <option value="Non-urgent Hiring" <?php echo ($row['priority'] == "Non-urgent Hiring") ? 'selected' : ''; ?>>
                                                                                        Non-urgent Hiring
                                                                                    </option>
                                                                                    <option value="Urgent Hiring" <?php echo ($row['priority'] == "Urgent Hiring") ? 'selected' : ''; ?>>
                                                                                        Urgent Hiring
                                                                                    </option>
                                                                                </select>
                                                                                <label for="priority"
                                                                                    class="form-label fw-bold">Priority</label>

                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="form-floating mb-2">
                                                                                <input type="text" class="form-control" id="shift"
                                                                                    placeholder="Ex. 8 hours shift" name="shift"
                                                                                    value="<?php echo $row['shift_and_schedule'] ?>"
                                                                                    required>

                                                                                <label for="shift" class="form-label">Shift &
                                                                                    Schedule</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="form-floating">
                                                                                <select class="form-select" name="jobType" id="jobType"
                                                                                    required>
                                                                                    <option value="Full-time" <?php echo ($row['job_type'] == "Full-time") ? 'selected' : ''; ?>>
                                                                                        Full-time
                                                                                    </option>
                                                                                    <option value="Part-time" <?php echo ($row['job_type'] == "Part-time") ? 'selected' : ''; ?>>
                                                                                        Part-time
                                                                                    </option>
                                                                                    <option value="Intern" <?php echo ($row['job_type'] == "Intern") ? 'selected' : ''; ?>>
                                                                                        Intern
                                                                                    </option>
                                                                                </select>

                                                                                <label for="jobType" class="form-label fw-bold">
                                                                                    Job Type
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="form-floating mb-2">
                                                                                <input type="text" class="form-control" id="location"
                                                                                    placeholder="Ex. Makati City" name="location"
                                                                                    value="<?php echo $row['location'] ?>" required>

                                                                                <label for="location"
                                                                                    class="form-label">Location</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="form-floating">
                                                                                <select class="form-select" name="department"
                                                                                    id="department" required>
                                                                                    <option value="IT" <?php echo ($row['department'] == "IT") ? 'selected' : ''; ?>>
                                                                                        IT
                                                                                    </option>
                                                                                    <option value="Human Resource" <?php echo ($row['department'] == "Human Resource") ? 'selected' : ''; ?>>
                                                                                        Human Resource
                                                                                    </option>
                                                                                    <option value="Legal" <?php echo ($row['department'] == "Legal") ? 'selected' : ''; ?>>
                                                                                        Legal
                                                                                    </option>
                                                                                    <option value="Operations" <?php echo ($row['department'] == "Operations") ? 'selected' : ''; ?>>
                                                                                        Operations
                                                                                    </option>
                                                                                    <option value="" <?php echo ($row['department'] == "") ? 'selected' : ''; ?>>
                                                                                        Add more here
                                                                                    </option>
                                                                                </select>

                                                                                <label for="department"
                                                                                    class="form-label fw-bold">Department</label>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col">

                                                                        <label for="jobDescription" class="form-label fw-bold">Job
                                                                            Description</label>
                                                                        <span class="text-secondary">(Qualifications)</span>
                                                                        <textarea class="form-control summernote" id="jobDescription"
                                                                            name="jobDescription"
                                                                            required><?php echo $row['job_description']; ?></textarea>

                                                                    </div>
                                                                </div>

                                                                <div class="row mt-2">
                                                                    <div class="col">
                                                                        <label for="benefits"
                                                                            class="form-label fw-bold">Benefits</label>
                                                                        <textarea class="form-control summernote" id="benefits"
                                                                            name="benefits"
                                                                            required><?php echo $row['benefits']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <button class="btn btn-danger w-100 mb-2 form-control mt-3"
                                                                    type="submit" name="editJobBtn">
                                                                    Submit
                                                                </button>

                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                            }
                            ?>
                        </tbody>
                    </table>