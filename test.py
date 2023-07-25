import sys

if __name__ == "__main__":
    if len(sys.argv) > 1:
        url_arg = sys.argv[1]

        url_value = url_arg.split("=")
        
        print(url_value)
    else:
        print("Please provide a URL argument.")

print(".env updated at:")
print("Sensor ID: "+str(123))