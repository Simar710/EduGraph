# API Documentation

-   The base URL for requests is https://cis3760f23-01.socs.uoguelph.ca/
-   Our API is defined as /courses/{functionality}/
    -   **The last forward slash is important**

### `GET /courses/getAllCourses/`

Get a list of all courses in the coursesDB database

> https://cis3760f23-01.socs.uoguelph.ca/courses/getAllCourses/ 

```
[
    {
        "courseCode": "ACCT*1220",
        "courseName": "Introductory Financial Accounting",
        "prerequisites": "()",
        "restrictions": "{ACCT*2220}"
    },
    {
        "courseCode": "ACCT*1240",
        "courseName": "Applied Financial Accounting",
        "prerequisites": "ACCT*1220 OR ACCT*2220",
        "restrictions": "{ACCT*2240}"
    }...
]
```

-   This endpoint does not accept any query parameters
-   This endpoint will return:
    -   **200** if the courses are fetched successfully from the database
    -   **405** if the request method given was not GET
    -   **500** if the connection to the database failed or fetching fails
---

### `GET /courses/getAllCoursesCopy/` 

Get a list of all courses in the coursesDBCopy database (used to verify POST, PUT, and DELETE operations)

> https://cis3760f23-01.socs.uoguelph.ca/courses/getAllCoursesCopy/ 

```
[
    {
        "courseCode": "ACCT*1220",
        "courseName": "Introductory Financial Accounting",
        "prerequisites": "()",
        "restrictions": "{ACCT*2220}"
    },
    {
        "courseCode": "ACCT*1240",
        "courseName": "Applied Financial Accounting",
        "prerequisites": "ACCT*1220 OR ACCT*2220",
        "restrictions": "{ACCT*2240}"
    }...
]
```

-   This endpoint does not accept any query parameters
-   This endpoint will return:
    -   **200** if the courses are fetched successfully from the database
    -   **405** if the request method given was not GET
    -   **500** if the connection to the database failed or fetching fails
---

### `GET /courses/getSubjects/` 

Get all the courses by a specified subject

> https://cis3760f23-01.socs.uoguelph.ca/courses/getSubjects/ 

```
[
    "ACCT",
    "AGR",
    "ANSC",
    "ANTH",
    "ARTH",
    "ARAB",
    "ASCI",
    "BIOC",
]
```

-   This endpoint will return:
    -   **200** if the subjects are fetched successfully from the database
    -   **405** if the request is an incorrect request method
    -   **500** if the connection to the database failed or fetching fails
---

### `POST /courses/getCoursesBySubject/` 

Get all the courses by a specified subject(s)

> https://cis3760f23-01.socs.uoguelph.ca/courses/getCoursesBySubject/ 

Input a JSON body like this containing 1 or more subjects in an array

Input:

```
{
    "subject": ["HROB"]
}
```

Result:

```
[
    {
        "courseCode": "HROB*2010",
        "courseName": "Foundations of Leadership",
        "prerequisites": "()",
        "restrictions": "{UNIV*2000}"
    },
    {
        "courseCode": "HROB*2090",
        "courseName": "Individuals and Groups in Organizations",
        "prerequisites": "()",
        "restrictions": "{HROB*2100,HROB*4000,PSYC*3080}"
    },
    {
        "courseCode": "HROB*2200",
        "courseName": "Labour Relations",
        "prerequisites": "2.00 credits",
        "restrictions": "{ECON*2200}"
    }
    ...
]
```

-   This endpoint will return:
    -   **200** if the course is fetched successfully from the database
    -   **400** if there is a malformed subject parameter
    -   **404** if no courses found for the given subject
    -   **405** if the request is an incorrect request method
    -   **500** if the connection to the database failed or fetching fails
---

### `POST /courses/getCourseByCode/` 

Get course details using the respective course code

> https://cis3760f23-01.socs.uoguelph.ca/courses/getCourseByCode/ 

Input a JSON body like this containing 1 or more course codes in an array

Input:

```
{
    "courseCode": ["cis*1300"]
}
```

Result:

```
[
    {
        "courseCode": "CIS*1300",
        "courseName": "Programming",
        "prerequisites": "()",
        "restrictions": "{CIS*1500}"
    }
]
```

-   This endpoint will return:
    -   **200** if the course is fetched successfully from the database
    -   **400** if the query parameter is not included in the call
    -   **404** if the course code was not found in the database
    -   **405** if the request method given was not POST
    -   **500** if the connection to the database failed or fetching fails
---

### `POST /courses/getCourseByName/` 

Get course details using the respective course name using fuzzy search

> https://cis3760f23-01.socs.uoguelph.ca/courses/getCourseByName/ 

Input a JSON body like this containing 1 or more course names in an array

Input:

```
{
    "courseName": ["intelligence"]
}
```

Result:

```
[
    {
        "courseCode": "CIS*4780",
        "courseName": "Computational Intelligence",
        "prerequisites": "CIS*3490 AND (CIS*3750 OR CIS*3760) AND (CIS*2460 OR STAT*2040)",
        "restrictions": "{}"
    },
    {
        "courseCode": "PHIL*3370",
        "courseName": "Ethics of Artificial Intelligence",
        "prerequisites": "1.50 credits in Philosophy OR 7.50 credits",
        "restrictions": "{}"
    }
]
```

-   This endpoint will return:
    -   **200** if the course(s) is fetched successfully from the database
    -   **400** if the query parameter is not included in the call
    -   **404** if the course name was not found in the database
    -   **405** if the request method given was not POST
    -   **500** if the connection to the database failed or fetching fails
---

### `POST /courses/getCoursesByPrereq/` 

Get courses by their prerequisites using the course code(s)

> https://cis3760f23-01.socs.uoguelph.ca/courses/getCoursesByPrereq/ 

Input a JSON body like this containing 0 or more prerequisites in an array and a **MANDATORY** type property

This type property will let the API know if you want OR logic or AND logic when multiple courses are specified, it will be ignored but still required when an empty array or 1 course is specified

When an empty array is specified, courses with no prerequisites will be returned

Input:

```
{
    "prerequisites": ["cis*2750", "cis*3490"]
    "type": "OR"
}
```

Result:

```
[
    {
        "courseCode": "CIS*3150",
        "courseName": "Theory of Computation",
        "prerequisites": "CIS*2750 AND CIS*3490",
        "restrictions": "{}"
    },
    {
        "courseCode": "CIS*3260",
        "courseName": "Software Design IV",
        "prerequisites": "CIS*2750 AND CIS*3250 AND CIS*3760",
        "restrictions": "{}"
    },
    {
        "courseCode": "CIS*3760",
        "courseName": "Software Engineering",
        "prerequisites": "CIS*2750 AND CIS*3750",
        "restrictions": "{}"
    },
    {
        "courseCode": "CIS*4020",
        "courseName": "Data Science",
        "prerequisites": "CIS*2750 AND MATH*1160 AND STAT*2040",
        "restrictions": "{}"
    },
    {
        "courseCode": "CIS*4030",
        "courseName": "Mobile Computing",
        "prerequisites": "CIS*2030 AND CIS*2750 AND CIS*3110",
        "restrictions": "{}"
    },
    {
        "courseCode": "CIS*4250",
        "courseName": "Software Design V",
        "prerequisites": "CIS*2750 AND CIS*3260",
        "restrictions": "{}"
    },
    {
        "courseCode": "CIS*4720",
        "courseName": "Image Processing and Vision",
        "prerequisites": "CIS*2750 AND CIS*3110 AND (CIS*2460 OR STAT*2040)",
        "restrictions": "{}"
    }
]
```

Input:

```
{
    "prerequisites": ["cis*2750", "cis*3490"],
    "type": "AND"
}
```

Result:

```
[
    {
        "courseCode": "CIS*3150",
        "courseName": "Theory of Computation",
        "prerequisites": "CIS*2750 AND CIS*3490",
        "restrictions": "{}"
    }
]
```

If an empty prerequisites array is given, the endpoint will return courses with **NO** prerequisites

Input:

```
{
    "prerequisites": [],
    "type": "AND"
}
```

Result:

```
[
    {
        "courseCode": "ACCT*1220",
        "courseName": "Introductory Financial Accounting",
        "prerequisites": "()",
        "restrictions": "{ACCT*2220}"
    },
    {
        "courseCode": "AGR*1110",
        "courseName": "Introduction to the Agri-Food Systems",
        "prerequisites": "()",
        "restrictions": "{AGR*1100,AGR*1250}"
    }...
]
```

-   This endpoint will return:
    -   **200** if the course(s) is fetched successfully from the database
    -   **404** if no matching prerequisites were found in the database or if the query parameter is not properly formatted
    -   **405** if the request method given was not POST
    -   **500** if the connection to the database failed or fetching fails
---

### `POST /courses/getCoursesByRestrictions/` 

Get courses by their restrictions using the course code(s)

> https://cis3760f23-01.socs.uoguelph.ca/courses/getCoursesByRestrictions/ 

Input a JSON body like this containing 0 or more restrictions in an array and a **MANDATORY** type property

This type property will let the API know if you want OR logic or AND logic when multiple courses are specified, it will be ignored but still required when an empty array or 1 course is specified

When an empty array is specified, courses with no restrictions will be returned

Input:

```
{
    "restrictions": ["cis*1500"],
    "type": "AND"
}
```

Result:

```
[
    {
        "courseCode": "CIS*1300",
        "courseName": "Programming",
        "prerequisites": "()",
        "restrictions": "{CIS*1500}"
    }
]
```

Input:

```
{
    "restrictions": ["cis*1500", "cis*1300"],
    "type": "AND"
}
```

Result:

```
{
    "error": "No matching restrictions found"
}
```

Input:

```
{
    "restrictions": ["cis*1500", "cis*1300"],
    "type": "OR"
}
```

Result:

```
[
    {
        "courseCode": "CIS*1300",
        "courseName": "Programming",
        "prerequisites": "()",
        "restrictions": "{CIS*1500}"
    },
    {
        "courseCode": "CIS*1500",
        "courseName": "Introduction to Programming",
        "prerequisites": "()",
        "restrictions": "{CIS*1300}"
    }
]
```

If an empty restrictions array is given, the endpoint will return courses with **NO** prerequisites

Input:

```
{
    "restrictions": [],
    "type": "OR"
}
```

Result:

```
[
    {
        "courseCode": "ACCT*2230",
        "courseName": "Management Accounting",
        "prerequisites": "ACCT*1220 OR ACCT*2220",
        "restrictions": "{}"
    },
    {
        "courseCode": "ACCT*3230",
        "courseName": "Intermediate Management Accounting",
        "prerequisites": "ACCT*2230",
        "restrictions": "{}"
    }...
]
```

-   This endpoint will return:
    -   **200** if the course(s) is fetched successfully from the database
    -   **404** if no matching restrictions were found in the database or the query parameter is not properly formatted
    -   **405** if the request method given was not POST
    -   **500** if the connection to the database failed or fetching fails
---

### `POST /courses/postCourses/` 

Update the coursesDBCopy table with a new course

> https://cis3760f23-01.socs.uoguelph.ca/courses/postCourses/ 

You must provide a JSON body like this:

```
{
    "courseCode": "CS*101",
    "courseName": "Introduction to Computer Science",
    "prerequisites": "()",
    "restrictions": "{}"
}
```

Adding the same course twice will return a 400 with:

```
{
    "error": "Course code already exists"
}
```

If you want prerequisites to be empty, there are two ways to achieve it:

1. Type in the field with "()". For example, "prerequisites": "()".
2. Do not mention the "prerequisites" parameter. For example:

```
{
    "courseCode": "CS*101",
    "courseName": "Introduction to Computer Science",
    "restrictions": "{}"
}
```

If you want restrictions to be empty, there are two ways to achieve it:

1. Type in the field with "{}". For example, "restrictions": "{}".
2. Do not mention the "restrictions" parameter. For example:

```
{
    "courseCode": "CS*101",
    "courseName": "Introduction to Computer Science",
    "prerequisites": "()"
}
```

-   This endpoint will return:
    -   **200** if the course is added successfully to the database
    -   **405** if the request method given was not POST
    -   **400** if the course information is incomplete, i.e., one or more of course code or course name or the parameters are provided without the value
    -   **500** if the connection to the database failed or fetching fails
---

### `PUT /courses/update/` 

Update a specific course's information in the coursesDBCopy table using a mandatory courseCode property

> https://cis3760f23-01.socs.uoguelph.ca/courses/update/ 

You must provide a JSON body like this:

```
{
    "courseCode": "CIS*1200",
    "courseName": "Intoduction to Programming",
    "prerequisites": "CIS*1000"
}
```

This will update the course CIS\*1200 with the value of the other properties specified

On successful update, the endpoint will return a JSON response like this:

```
{
    "message": "Current Info",
    "originalRow": {
        "courseCode": "\"CIS*1200\"",
        "courseName": "Intro to Programming",
        "prerequisites": "CIS*1000",
        "restrictions": "\"{CIS*1000}\""
    },


    "updatedRow": {
        "courseCode": "\"CIS*1200\"",
        "courseName": "Introduction to Programming",
        "prerequisites": "CIS*1000",
        "restrictions": "\"{CIS*1000}\""
    }
}
```

All 3 fields can be updated at once and only the fields that you want to update should be stated

If the update is not for courseName, prerequisites, and restrictions, it will then return "error": "No valid update data provided" which is a 400 bad request

-   This endpoint will return:
    -   **200** if the course is retrieved successfully from the database
    -   **400** if invalid data is input or missing courseCode in the request or course is not found
    -   **405** if the request method given was not PUT
    -   **500** if the connection to the database failed or fetching fails
---

### `DELETE /courses/delete/` 

Delete a course from the coursesDBCopy table by the courseCode

> https://cis3760f23-01.socs.uoguelph.ca/courses/delete/ 

You must provide a JSON body like this:

```
{
    "courseCode": "cis*1300"
}
```

On successful deletion, the endpoint will return this:

```
{
    "message": "Course deleted successfully"
}
```

-   This endpoint will return:
    -   **200** if the course is found and deleted successfully from the database
    -   **400** if invalid data is input or missing courseCode in the request body
    -   **404** if the course was not found in the database
    -   **405** if the request method given was not DELETE
    -   **500** if the connection to the database failed or fetching fails
