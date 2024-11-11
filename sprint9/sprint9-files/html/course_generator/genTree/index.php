<?php $pageTitle = "Course Tree Page"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
      <?php include "index.css" ?>
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Merriweather:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- link bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <title><?php echo $pageTitle; ?></title>
</head>
<body>
    <div class="home">
      <a href="/" aria-label="Home"><button class="btn-home" aria-label="home button" tabindex="-1"><i class="fa fa-home"></i></button></a>
    </div>
    <label class="switch" tabindex="0" role="switch">
      <input type="checkbox" class="toggle-dark-mode">
      <span class="slider">
        <span class="toggle-icons">
          <i class="fa fa-moon"></i> <!-- Moon icon -->
          <i class="fa fa-sun"></i> <!-- Sun icon -->
        </span>
      </span>
    </label>
    <!-- hero page -->
    <div class="container hero-img col-xxl-8 px-4 py-1">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-3">
            <div class="col-10 col-sm-8 col-lg-6">
                <img src="images/treeImg.webp" class="d-block mx-lg-auto img-fluid" alt="hero image" loading="lazy">
            </div>
            <div class="col-lg-6">
                <div class="lc-block mb-3">
                    <div editable="rich">
                        <h2 class="fw-bold display-5">UoG Course Tree Generator</h2>
                    </div>
                </div>

                <div class="lc-block mb-3">
                    <div editable="rich">
                        <p class="lead">Introducing our Course Tree Generator – The Ultimate tool to allow you to see all the relations behind any course you want! Simply choose which subject you are interested in, and click the button to generate the tree! Have fun and happy pre-requiste searching.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container col-xlg-8">
      <div class="row flex-lg align-items-center justify-content-center py-3">
        <div class="col-md-3">
            <div class="dropdown" id="genTreeDropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                  Select Subject
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"></div>
              <div id="chosenSubject">Subject Chosen: <span id="subjectValue"></span></div>
            </div>
        </div>

        <div class="col-md-3">
            <div id="genTreeBtn" class="lc-block text-center">
                <button class="btn btn-dark px-4 me-md-2" aria-label="Generate Course Tree">Generate Course Tree</button>
            </div>
        </div>

        <div class="col-md-3">
            <div id="genTreeBtnAll" class="lc-block text-center">
                <button class="btn btn-dark px-4 me-md-2" aria-label="Generate All Courses Tree">Generate All Courses Tree</button>
            </div>
        </div>

        <div class="col-md-3">
          <div id="download" class="lc-block text-center">
            <button class="btn btn-dark px-4 me-md-2" aria-label="Download Tree">Download Tree</button>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-3">
        <div class="col">
              <div class="input-group mb-3 search-container">
                <input type="text" id="searchInput" class="form-control" style="max-width: 200px;" placeholder="Search for a course...">
                <button id="searchBtn" class="btn btn-outline-secondary" type="button">Search</button>
              </div>

            <div id="loading-container">
              <div id="loading-overlay">
                  <div class="loading-spinner"></div>
              </div>
              <div id="tree-container" class = "canvas-gen"></div>
            </div>
        </div>
    </div>


    <script type="text/javascript">

    const loadingOverlay = document.getElementById("loading-overlay");
    function htmlTitle(html) {
      const container = document.createElement("div");
      container.innerHTML = html;
      return container;
    }

    function showLoading() {
      loadingOverlay.style.display = "flex";
      loadingOverlay.style.pointerEvents = "none"; // Allow interaction
    }

    function hideLoading() {
      loadingOverlay.style.display = "none";
    }

    function updateEdgeColors(nodeId) {
      const connectedEdges = network.getConnectedEdges(nodeId);

      connectedEdges.forEach((edgeId) => {
        const edge = network.body.edges[edgeId];
        if (edge.fromId !== nodeId) {
          network.clustering.updateEdge(edgeId, { color: { highlight: 'blue', hover: 'blue' } });
        } else {
          network.clustering.updateEdge(edgeId, { color: { highlight: 'red', hover: 'red' } });
        }
      });
    }

    async function getSubjects() {
      const response = await fetch("http://localhost:8082/courses/getSubjects/", {
        method: "GET",
        mode: "cors",
        headers: {
          "Content-Type": "application/json"
        }
      });
      return response.json()
    }

    async function getAllCourses() {
      const response = await fetch("http://localhost:8082/courses/getAllCourses/", {
        method: "GET",
        mode: "cors",        headers: {
          "Content-Type": "application/json"
        }
      });
      return response.json()
    }

    async function buildChartData(courseId) {
      const courses = await fetch("http://localhost:8082/courses/getCoursesByPrereq/", {
        method: "POST",
        mode: "cors",
        body: JSON.stringify({
          prerequisites: [courseId],
          type: "AND",
        }),
      });

      const data = await courses.json()
      return data;
    }

    let genTreeCourses = [];
    let allCourses = [];
    let network;

    document.addEventListener("DOMContentLoaded", async function() {
      // SEARCH FEATURE
      const searchInput = document.getElementById("searchInput");
      const searchBtn = document.getElementById("searchBtn");

      // Add a searchInput kb shortcut
      searchInput.addEventListener("keypress", function(event){
        if (event.key == "Enter"){
          searchBtn.click();
        }
      });

      searchBtn.addEventListener("click", function () {
        const searchText = searchInput.value.trim().toUpperCase();

        if (network && searchText !== "") {
          const nodeIds = network.body.data.nodes.getIds();
          const foundNode = nodeIds.find((id) => {
            const label = network.body.data.nodes.get(id).label.toUpperCase();
            return label.includes(searchText);
          });

          if (foundNode) {
            network.selectNodes([foundNode]);
            network.focus(foundNode, { scale: 2.0 });
            updateEdgeColors(foundNode);
          } else {
            alert("Course not found!");
          }
        }
      });

      // Courses for a specific subject in order to gen tree
      let dropdownMenu = document.querySelector(".dropdown-menu");

      const data = await getSubjects()
      data.forEach(subject => {
        const dropdownItem = document.createElement("a");
        dropdownItem.classList.add("dropdown-item");
        dropdownItem.textContent = subject;
        dropdownItem.setAttribute("tabindex", "-1");
        dropdownMenu.appendChild(dropdownItem);
      });

      const data2 = await getAllCourses()
      data2.forEach(course => {
          allCourses.push(course);
      });

      // Ability to cycle through course options
      dropdownMenu.addEventListener("keypress", function(event) {
        if (dropdownMenu.classList.contains("show")) {

            if (event.key == "Enter"){
              let focusedElement = document.activeElement;

              // Check if the focused element is a dropdown item
              if (focusedElement.classList.contains("dropdown-item")) {
                  focusedElement.click();
              }
            }

        }
      });

      // Get the value in the dropdown and populate a list with relevant courses
      dropdownMenu.addEventListener("click", async function(e) {
        genTreeCourses = []
        const subject = e.target.innerText;
        const response = await fetch("http://localhost:8082/courses/getCoursesBySubject/", {
          method: "POST",
          mode: "cors",
          headers: {
              "Content-Type": "application/json"
          },
          body: JSON.stringify({
            subject: [subject]
          }),
        });
        const data = await response.json();
        data.forEach((d) => {
          genTreeCourses.push(d);
        });
        subjectValue.textContent = subject;
      });

      const generate_button = document.getElementById("genTreeBtn");
      const generate_all_button = document.getElementById("genTreeBtnAll");

      generate_button.addEventListener("click", async function(e) {
        e.preventDefault();
        showLoading();
        // ensure if there was an old graph, to destroy it
        if (network) {
          network.destroy();
        }

        let nodes = []
        let edges = []

        // this will create nodes for every course in the subject
        genTreeCourses.forEach((course) => {
          nodes.push({
            id: course.courseCode,
            label: course.courseCode,
            title: htmlTitle(
              `${course.courseName}`
            ),
          })
        })

        // this is where we create the edges based on API call
        // use Promise.all to make API calls concurrently
        await Promise.all(
          genTreeCourses.map(async (course) => {
            const courses = await buildChartData(course.courseCode);
            courses.forEach((c) => {
              edges.push({
                from: course.courseCode,
                to: c.courseCode,
              });
            });
          })
        );

        let container = document.getElementById('tree-container');
        let data = {
          nodes: nodes,
          edges: edges
        };

        let options = {
          edges: {
            smooth: true,
            arrows: { to: true },
            hoverWidth: 2.0,
            color: {
              highlight: 'red',
              hover: 'red',
            },
          },
        };
        network = new vis.Network(container, data, options)

        // change the colour of the edges that go to the node and from the node
        network.on('click', function (params) {
          if (params.edges.length > 0) {
            let clickedNode = params.nodes[0]
            params.edges.forEach((edge) => {
              let currentEdge = network.body.edges[edge]
              if (currentEdge.fromId !== clickedNode) {
                network.clustering.updateEdge(currentEdge.id, { color: { highlight: 'blue', hover: 'blue'} }); // Color for incoming arrows to the node
              } else {
                network.clustering.updateEdge(currentEdge.id, { color: { highlight: 'red', hover: 'red'} }); // Color for outgoing arrows to the node
              }
            })
          }
        });
        network.on('afterDrawing', (params) => {
          hideLoading();
        })
      });

      // IF U WANT TO GEN ALL COURSES TREE
      generate_all_button.addEventListener("click", async function(e) {
        e.preventDefault();
        showLoading();
        // ensure if there was an old graph, to destroy it
        if (network) {
          network.destroy();
        }

        let nodes = []
        let edges = []

        // this will create nodes for every course in the subject
        allCourses.forEach((course) => {
          nodes.push({
            id: course.courseCode,
            label: course.courseCode,
            title: htmlTitle(
              `${course.courseName}`
            ),
          })
        })

        // this is where we create the edges based on API call
        // THIS IS FOR CHROME
        if (window.navigator.userAgent.includes("Chrome")) {
          for (const course of allCourses) {
            const courses = await buildChartData(course.courseCode);
            courses.forEach((c) => {
              edges.push({
                from: course.courseCode,
                to: c.courseCode
              })
            })
          }
        } else {
          // use Promise.all to make API calls concurrently
          await Promise.all(
            allCourses.map(async (course) => {
              const courses = await buildChartData(course.courseCode);
              courses.forEach((c) => {
                edges.push({
                  from: course.courseCode,
                  to: c.courseCode,
                });
              });
            })
          );
        }

        let container = document.getElementById('tree-container');
        let data = {
          nodes: nodes,
          edges: edges
        };

        let options = {
          edges: {
            smooth: false,
            arrows: { to: true },
            hoverWidth: 2.0,
            color: {
              highlight: 'red',
              hover: 'red',
            },
          },
        };
        network = new vis.Network(container, data, options)

        // change the colour of the edges that go to the node and from the node
        network.on('click', function (params) {
          if (params.edges.length > 0) {
            let clickedNode = params.nodes[0]
            params.edges.forEach((edge) => {
              let currentEdge = network.body.edges[edge]
              if (currentEdge.fromId !== clickedNode) {
                network.clustering.updateEdge(currentEdge.id, { color: { highlight: 'blue', hover: 'blue'} }); // Color for incoming arrows to the node
              } else {
                network.clustering.updateEdge(currentEdge.id, { color: { highlight: 'red', hover: 'red'} }); // Color for outgoing arrows to the node
              }
            })
          }
        });
        network.on('afterDrawing', (params) => {
          hideLoading();
        })
      });
    });

    // JavaScript for toggling dark mode    
    document.addEventListener('DOMContentLoaded', function() {
            const toggleSwitch = document.querySelector('.toggle-dark-mode');
            const body = document.body;

            // Check for dark mode preference in local storage
            const darkMode = localStorage.getItem('darkMode');
            
            // If dark mode is stored in local storage, apply it
            if (darkMode === 'enabled') {
                body.classList.add('dark-mode');
                toggleSwitch.checked = true;
            }

            toggleSwitch.addEventListener('change', function() {
                if (this.checked) {
                    body.classList.add('dark-mode');
                    localStorage.setItem('darkMode', 'enabled');
                } else {
                    body.classList.remove('dark-mode');
                    localStorage.setItem('darkMode', null);
                }
            });
        });

    // Javascript for downloading file
    document.addEventListener("DOMContentLoaded", function() {

      function downloadTree() {
        network.on("afterDrawing", function () {

          const canvas = network.canvas.frame.canvas;
          const dataURL = canvas.toDataURL("image/png");

          const link = document.createElement("a");
          link.href = dataURL;
          link.download = "tree.png";
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);

          network.off("afterDrawing");
        });

        network.redraw();
      }
      const download = document.getElementById("download");
      download.addEventListener("click", function() {

        downloadTree();
      });
    });
  </script>
</body>
</html>
