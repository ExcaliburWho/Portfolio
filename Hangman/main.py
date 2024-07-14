
title="H A N G M A N"
print(title.center(13))
print("- - - - - - -")
print ("\nStart guessing...\n")

word = ("petrichor").upper()
guesses = ''
turns = 10
list=[]

while turns > 0:         
    failed = 0
    for letter in word:      
        if letter in guesses:    
            _=print(letter,end=" "),    
        else:
            _=print("_ ",end=" "),     
            failed += 1    
    if failed == 0:  
        print("\n")
        print ("\nYou won!")
        break   
    guess = input("Guess a letter: ").upper()
    list.append(guess)
    newlist=' '.join(list)
    guesses += guess                    
    if guess not in word:  
        turns -= 1        
        print ("\nThat's not in this word!")  
        print ("You have", + turns, 'wrong guesses left\n' )
        if turns == 0:           
            print ("You Lose"  )
    print("\n",newlist,"have already been guessed\n")
