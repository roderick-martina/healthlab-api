# HealthlabApi
Healthlab Api

# Routes
These can be used alone like this

| resource      | description                       |
|:--------------|:----------------------------------|
| `/patients`      | returns a list of all patients (id , identifier), 10 per page
| `/mbca`    | returns a list of all Mbca results (id , created, birthday, doctor, ethnic, bmi, ect)



## Parameters

Parameters can be used to query, filter and control the results returned by the Crossref API. They can be passed as normal URI parameters or as JSON in the body of the request.

| route            | parameter                    | description                 |
|:-----------------|:-----------------------------|-----------------------------|
| `api/Mbca`       | age={startValue}\|{endValue} | Returns list of mbca results filtered by age parameters
| `api/Mbca`       | gender={gender} | Returns list of mbca results filtered by gender (Male or Female) (parameter is case sensitive)
| `api/Mbca`       | ethnic={ethnicity} | Returns list of mbca results filtered by etnicity (parameter is case sensitive)
| `api/Mbca`       | date={date} | Returns list of mbca results filtered by date (Date format must be (Y-m-d)
| `api/Mbca`       | age-order={direction} | Returns list of mbca results ordered by age (desc or asc)
| `api/Mbca`       | date-order={direction} | Returns list of mbca results ordered by date (desc or asc)
                        
