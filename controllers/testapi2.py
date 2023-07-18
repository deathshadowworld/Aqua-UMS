import requests

# Send a GET request to obtain the CSRF token
url = 'http://localhost:8080/admin/api/csrf-token'  # Replace with the actual URL to retrieve the token
response = requests.get(url)

# Extract the CSRF token from the response
csrf_token = response.headers['X-CSRF-Token']  # Replace 'X-CSRF-Token' with the actual header name for the token

# Use the CSRF token in your subsequent POST request
post_url = 'http://localhost:8080/admin/api/add-sensor'  # Replace with the actual URL to submit data
payload = {
    'data': 'your_data_here',
    'csrf_token': csrf_token
}

response = requests.post(post_url, data=payload)
print(response.text)