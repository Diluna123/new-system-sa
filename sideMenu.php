<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
          <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="sidebarMenuLabel">SANASA LIFE</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
              <ul class="nav flex-column">
                <?php

                $sessiom_Data = $_SESSION['user'];
                if ($sessiom_Data['position_pid'] == '2') {
                ?>
                  <li class="nav-item">
                    <a href="adminIndex.php" class="nav-link d-flex align-items-center gap-2 " aria-current="page" onclick="">
                      <svg class="bi">
                        <use xlink:href="#admin" />
                      </svg>
                      Admin Panel
                    </a>
                  </li>

                <?php

                }


                ?>

                <li class="nav-item">
                  <a href="index.php" class="nav-link d-flex align-items-center gap-2 " aria-current="page" onclick="">
                    <svg class="bi">
                      <use xlink:href="#house-fill" />
                    </svg>
                    Dashboard
                  </a>
                </li>
                <li class="nav-item">
                  <a href="myPolicies.php" class="nav-link d-flex align-items-center gap-2" onclick="">
                    <svg class="bi">
                      <use xlink:href="#file-earmark" />
                    </svg>
                    My Policies
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2" href="cutomerLeets.php">
                    <svg class="bi">
                      <use xlink:href="#people" />
                    </svg>
                    Customer Leads
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2 " href="mbileDay.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bus-front" viewBox="0 0 16 16">
                      <path d="M5 11a1 1 0 1 1-2 0 1 1 0 0 1 2 0m8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-6-1a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2zm1-6c-1.876 0-3.426.109-4.552.226A.5.5 0 0 0 3 4.723v3.554a.5.5 0 0 0 .448.497C4.574 8.891 6.124 9 8 9s3.426-.109 4.552-.226A.5.5 0 0 0 13 8.277V4.723a.5.5 0 0 0-.448-.497A44 44 0 0 0 8 4m0-1c-1.837 0-3.353.107-4.448.22a.5.5 0 1 1-.104-.994A44 44 0 0 1 8 2c1.876 0 3.426.109 4.552.226a.5.5 0 1 1-.104.994A43 43 0 0 0 8 3" />
                      <path d="M15 8a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1V2.64c0-1.188-.845-2.232-2.064-2.372A44 44 0 0 0 8 0C5.9 0 4.208.136 3.064.268 1.845.408 1 1.452 1 2.64V4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v3.5c0 .818.393 1.544 1 2v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5V14h6v1.5a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2c.607-.456 1-1.182 1-2zM8 1c2.056 0 3.71.134 4.822.261.676.078 1.178.66 1.178 1.379v8.86a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 11.5V2.64c0-.72.502-1.301 1.178-1.379A43 43 0 0 1 8 1" />
                    </svg>
                    Mobile Day
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2" href="Products.php">
                    <svg class="bi">
                      <use xlink:href="#cart" />
                    </svg>
                    Products
                  </a>
                </li>


                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2" href="#">
                    <svg class="bi">
                      <use xlink:href="#graph-up" />
                    </svg>
                    Reports
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2" href="#">
                    <svg class="bi">
                      <use xlink:href="#puzzle" />
                    </svg>
                    Salery
                  </a>
                </li>
              </ul>

              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
                <span>Saved reports</span>
                <a class="link-secondary" href="#" aria-label="Add a new report">
                  <svg class="bi">
                    <use xlink:href="#plus-circle" />
                  </svg>
                </a>
              </h6>
              <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2" href="#">
                    <svg class="bi">
                      <use xlink:href="#file-earmark-text" />
                    </svg>
                    Current month
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2" href="#">
                    <svg class="bi">
                      <use xlink:href="#file-earmark-text" />
                    </svg>
                    Last quarter
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2" href="#">
                    <svg class="bi">
                      <use xlink:href="#file-earmark-text" />
                    </svg>
                    Social engagement
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2" href="#">
                    <svg class="bi">
                      <use xlink:href="#file-earmark-text" />
                    </svg>
                    Year-end sale
                  </a>
                </li>
              </ul>

              <hr class="my-3">

              <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2" href="#">
                    <svg class="bi">
                      <use xlink:href="#gear-wide-connected" />
                    </svg>
                    Settings
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2" href="#" onclick="signOut();">
                    <svg class="bi">
                      <use xlink:href="#door-closed" />
                    </svg>
                    Sign out
                  </a>
                </li>
              </ul>
              <div class="row mt-5 m-2">
                <div class="card ">
                  <div class="card-body">

                    <h6 class="text-warning m-0"><?php echo $_SESSION['user']['u_fname'] ?> <?php echo $_SESSION['user']['u_lname'] ?></h6>
                    <small class="m-0"><?php echo $_SESSION['user']['email']; ?></small>
                    <div>
                      <?php
                      $positionD = Database::search("SELECT * FROM `position` WHERE `pid` = '" . $_SESSION['user']['position_pid'] . "'");
                      $positionData = $positionD->fetch_assoc();


                      ?>
                      <span class="badge text-bg-warning"><?php echo $positionData['position']; ?></span>

                    </div>



                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>