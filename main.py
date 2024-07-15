#FILE HANDLING
userInfo=open("user.txt","a+")
qus=open("Questions.txt","r")
ans=open("Multiple choice.txt","r")
corr=open("Answers.txt","r")

#USER SETUP
name=input("Enter name: ").capitalize()
age=input("Enter age: ")
yr=input("Enter year group: ")
user=name[0:3]+age
print("\nYour username is",user)
password=input("Enter a password using letters only: ")
print("----------------------------------------")

#TOPIC AND DIFF
print("\n1. History\n2. Music\n3. Computer Science\n")
topic=int(input("Select a topic for quizzing: "))
print("\n1. Easy\n2. Medium\n3. Hard\n")
diff=int(input("Select difficulty: "))
print("----------------------------------------\n")

#QUESTIONS
question=qus.readlines()
multi=ans.readlines()
correct=corr.readlines()

#SUBPROGAMS
score=0
def read_qus():
  global score
  for x in range(y,z):
    print(question[x])
    print(multi[x])
    print("----------------------------------------\n")
    answer=int(input("Enter answer as number: "))
    CoRrEcT=int(correct[x])
    if answer==CoRrEcT:
      print("--> Correct\n")
      score+=1
    else:
      print("--> Incorrect\n")
    
#SELECTION
if topic==1:
  if diff==1:
    y=0
    z=5
    read_qus()
  elif diff==2:
    y=5
    z=10
    read_qus()
  elif diff==3:
    y=10
    z=15
    read_qus()
elif topic==2:
  if diff==1:
    y=15
    z=20
    read_qus()
  elif diff==2:
    y=20
    z=25
    read_qus()
  elif diff==3:
    y=25
    z=30
    read_qus()
elif topic==3:
  if diff==1:
    y=30
    z=35
    read_qus()
  elif diff==2:
    y=35
    z=40
    read_qus()
  elif diff==3:
    y=40
    z=45
    read_qus()

#GRADING
grade="0 - Fail"
if score==0:
  print("I'm sorry, you got 0% so failed this quiz. Please try again later")
  grade="0 - Fail"
elif score==1:
  print("You got a grade D with 20%")
  grade="20 - D"
elif score==2:
  print("You got a grade C with 40%")
  grade="40 - C"
elif score==3: 
  print("You got a grade B with 60%")
  grade="60 - B"
elif score==4:
  print("You got a grade A with 80%")
  grade="80 - A"
elif score==5:
  print("You got a grade A+ with 100%")
  grade="100 - A+"
userInfo.writelines("Name:"+name+"\nAge:"+age+"\nYear:"+yr+"\nUser:"+user+"\nPassword:"+password+"\nGrade:"+grade+"\n\n")
  
