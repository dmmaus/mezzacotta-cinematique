import Tkinter
import random
import string

def randomline(filename, plural, cap):
    global atword

    story = ""
    lines = []

    rline = ""

    f = open(filename + ".txt", "r")

    for line in f:
        if line.startswith("^") and random.randrange(0, 10) < 5:
            rline = line[1:]
            break;
        if line.startswith("&"):
            cap = True

        elif len(line) == 0:
            print "THERE IS A BLANK LINE"
        elif not line.startswith("#"):
            lines.append(line)


    f.close()

    if rline == "":
        rline = lines[random.randrange(0, len(lines))]

    #print "FROM", filename, "CHOSE:", rline

    words = rline.split()


    for word in words:
        if word == "@":
            word = atword
            atword = ""
        elif "@" in word:
            atword = word[1:]
            word = ""

        if "|" in word:
            pos = string.find(word, "|")
            if not plural:
                word = word[:pos]
            else:
                word = word[pos + 1:]

        if "$" in word:
            pos = string.find(word, "$")
            if pos == 0:
                chance = 10
            else:
                chance = int(word[:pos])

            if chance > random.randrange(0, 10):
                story += randomline(word[pos + 1:], False, cap)


        elif word.startswith("*"):
            story += randomline(word[1:], True, cap)
        else:
            if cap:
                word = word.capitalize()
            story += word + " "

    return story

def process_tagline(tagline):
    reps = {"  ":" ", " .":".", " ,":",", " !":"!", " ?":"?", " _":"", " :":":", "- ":"-",
           " a a":" an a", " a e":" an e"," a o":" an o"," a u":" an u"," a i":" an i",
           " a A":" an A", " a E":" an E"," a O":" an O"," a U":" an U"," a I":" an I",
           " A A":" An A", " A E":" An E"," A O":" An O"," A U":" An U"," A I":" An I",
           " a the":" the", " the the":" the", " The The":" The", "?.":"?", " )":")", " +":"-", "+ ":"-",
           "( ":"(", "  ":" ", " '":"'", '"_ ':'"', ' _"':'"', "<br/>":"\n"
           }

    for key in reps.keys():
        if key in tagline:
            tagline = tagline.replace(key, reps[key])

    tagline = tagline.lstrip()

    a = tagline[0]
    b = tagline[1:]

    return a.capitalize() + b


class simpleapp_tk(Tkinter.Tk):
    def __init__(self,parent):
        Tkinter.Tk.__init__(self,parent)
        self.parent = parent
        self.initialize()

    def initialize(self):
        self.grid()



        button = Tkinter.Button(self,text=u"Generate",
                                command=self.OnButtonClick)
        savebtn = Tkinter.Button(self, text=u"Classic!", command=self.OnSaveClick)

        backbtn = Tkinter.Button(self, text=u"What was THAT?", command=self.OnBackClick)


        button.grid(column=1,row=0)
        savebtn.grid(column=2, row=0)
        backbtn.grid(column=3, row=0)

        self.labelVariable = Tkinter.StringVar()
        self.titleVariable = Tkinter.StringVar()
        self.ratingVariable = Tkinter.StringVar()
        self.castVariable = Tkinter.StringVar()

        label = Tkinter.Label(self,textvariable=self.labelVariable,
                              anchor="w", height=6, wraplength=800, font=("Helvetica", 24), width=42)

        rating = Tkinter.Label(self,textvariable=self.ratingVariable,
                              anchor="w", height=2, wraplength=800, foreground="red", font=("Helvetica", 12), width=42)

        title = Tkinter.Label(self,textvariable=self.titleVariable, foreground="blue",
                              anchor="w", height=2, wraplength=800, font=("Helvetica", 32))

        cast = Tkinter.Label(self,textvariable=self.castVariable, foreground="darkgreen",
                              anchor="w", height=3, wraplength=800, font=("Helvetica", 16))

        label.grid(column=0,row=4,columnspan=2,sticky='EW')
        cast.grid(column=0,row=3,columnspan=2,sticky='EW')
        rating.grid(column=0, row=2, columnspan=2, sticky='EW')
        title.grid(column=0,row=1,columnspan=2,sticky='EW')

        self.labelVariable.set(u"Plot")
        self.titleVariable.set(u"Title")
        self.ratingVariable.set(u"Rating")
        self.castVariable.set(u"Cast")

        self.grid_columnconfigure(0,weight=1)
        self.resizable(True,False)
        self.update()
        self.geometry(self.geometry())


    def OnButtonClick(self):
        self.OldTitle = self.titleVariable.get()
        self.OldPlot = self.labelVariable.get()

        tagline = " " + randomline("basemovie", False, False)
        processed_tagline = process_tagline(tagline)
        self.labelVariable.set(processed_tagline)
        movie_plot = processed_tagline

        title = " " + randomline("title", False, False)
        processed_title = process_tagline(title)
        self.titleVariable.set(processed_title)
        movie_title = processed_title

        rating = " " + randomline("rating", False, False)
        processed_rating = process_tagline(rating)
        self.ratingVariable.set(processed_rating)
        movie_rating = processed_rating

        cast = " " + randomline("cast", False, False)
        processed_cast = process_tagline(cast)
        self.castVariable.set(processed_cast)
        movie_cast = processed_cast


    def OnSaveClick(self):
        c = open("classic_films.txt", 'a')
        c.write(self.titleVariable.get() + "\n" + self.labelVariable.get() + "\n\n")
        c.close()

    def OnBackClick(self):
        self.titleVariable.set(self.OldTitle)
        self.labelVariable.set(self.OldPlot)



if __name__ == "__main__":
    global atword
    global movie_plot
    global movie_title

    atword = ""
    movie_plot = ""
    movie_title = ""

    app = simpleapp_tk(None)
    app.title('mezzacotta cinematheque')
    app.mainloop()