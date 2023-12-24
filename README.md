<p align="center">
<img align="center" alt="PHP" height="30" width="40" src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-plain.svg">
<img align="center" alt="Tailwindcss" height="30" width="40" src="https://github.com/devicons/devicon/raw/master/icons/tailwindcss/tailwindcss-plain.svg">
</p>

# <p align="center">package web php [closed]</p>

package.anytion is the open-source library & template repository to install on your PHP project by [control](https://github.com/Arikato111/control)

status: Closed for maintenance, plan for use typescript with nextjs.

## Get started

### Run with apache or xampp

- clone this repository
- move files to root directory project (htdocs/)
- import `Database.sql` into your database or create a database from the table below.
- create `.env` and enter connection details on `.env`
- `npm install` to to install mode_modules
- `npm run build` to run tailwindcss
- open [http://localhost](http://localhost) on your browser

### Run with [control](https://github.com/Arikato111/control)

- clone this repository
- import `Database.sql` into your database or create a database from the table below.
- create `.env` and enter connection details on `.env`
- `npm install` to to install mode_modules
- `npm run build` to run tailwindcss
- `php control serve` 
- open [http://localhost:3000](http://localhost:3000) on your browser

## Inside it 

- [NEXIT PHP](https://github.com/Arikato111/NEXIT)
- Tailwindcss
- [control](https://github.com/Arikato111/control)

## Database [ MySQL ]

Table name: **follow**

| Field | Type | Key | Extra |
| ----- | ---- | --- | ---- |
| id | int(11) | PRI | auto_incroment | 
| atk | varchar (50) |      |
| def | varchar (50) |
| date | varchar (20) |

---

Table name: **logined**

| Field | Type | Key | Extra |
| ----- | ---- | --- | ---- |
| id | int(11) | PRI | auto_incroment | 
| token1 | varchar (40) |  | |
| token2 | varchar (40) |  | |
| user_id | int(11) |   |
| date | varchar (20) |

---

Table name: **package**

| Field | Type | Key | Extra |
| ----- | ---- | --- | ---- |
| id | int(11) | PRI | auto_incroment | 
| name | varchar (50) |  | |
| descript | text |  | |
| github | varchar (120) |  | |
| installer | varchar (120) |  | |
| dev | varchar (50) |  | |
| date | varchar (20) |
| modif | varchar (20) |
| type | int(1) |
| download | int(11) |

---

Table name: **user**

| Field | Type | Key | Extra |
| ----- | ---- | --- | ---- |
| id | int(11) | PRI | auto_incroment | 
| name | varchar (50) |  | |
| username | varchar (50) |  | |
| password | varchar (40) |  | |
| descript | text |  | |
| question | varchar (50) |  | |
| answer | varchar (50) |  | |
| date | varchar (20) |  | |
| follow| int(10) |

---

Table name: **vertion**

| Field | Type | Key | Extra |
| ----- | ---- | --- | ---- |
| id | int(11) | PRI | auto_incroment | 
| package_name | varchar (50) |  | |
| version | varchar (50) |  | |
| descript | text |  | |
| github | varchar (120) |  | |
| installer | varchar (120) |  | |
| date | varchar (20) |  | |
| modif | varchar (20) |  | |
| type | int(1) |

---