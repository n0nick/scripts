import string

f = open('B-large-practice.in')
N = int(f.readline())
for i in range(0,N):
	s = f.readline()
	a = s.split()
	a.reverse()
	r = string.join(a)
	print "Case #" + str(i+1) + ":", r