# Google Calendar Alfred Workflow

## Functions:

- Quick add an event

## Download

* [Download Workflow](https://github.com/mkoziy/alfred-google-calendar/blob/0.1/Google%20Calendar.alfredworkflow).
* Install using Alfred.

## Setup

1. Create Google API credentials.

   - Visit [developers console](https://console.developers.google.com)
   - Create credentials. Go to the `Credentials` page, press `Create credentials` button, choose `Service account key`, download the json file.
   - Copy text from the json file.
   - Open  `Alfred Workflow` tab, find the `Google Calendar` workflow, press `configure workflow and variables` button, paste the copied text to value of the `CALENDAR_API_CREDENTIALS`  variable.

2. Google Calendar ID.

   - Visit [Google Calendar](https://calendar.google.com)

   - Go to the `Settings and sharing` page of your calendar, find `Calendar ID` and copy it.

   - Open  `Alfred Workflow` tab, find the `Google Calendar` workflow, press `configure workflow and variables` button, paste the copied calendar id to value of the `CALENDAR_ID`  variable.

3. Share the calendar.

   - Find `client_email` in saved credentials(json file). Copy it.

   - Visit [Google Calendar](https://calendar.google.com)

   - Go to the `Settings and sharing` page of your calendar, find `Share with specific people`, add the copied `client_email`, choose `Make changes to events` permissions.



## Usage

- Quick add. Type `gcqa Appointment at Somewhere on June 3rd 10am-10:25am`



## ToDo

* Quick add to different calendars
* The events list