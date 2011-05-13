from __future__ import print_function

keys = [
		[' '],
		[], ['a','b','c'], ['d','e','f'],
		['g','h','i'],['j','k','l'],['m','n','o'],
		['p','q','r','s'],['t','u','v'],['w','x','y','z']
		]

f = open('C-large-practice.in')
N = int(f.readline())
for i in range(0,N):
	print("Case #" + str(i+1) + ":", end=' ')
	s = f.readline()
	lk = ''
	for c in s:
		for key, letters in enumerate(keys):
			for r, l in enumerate(letters):
				if l==c:
					if key==lk:
						print('', end=' ')
					else:
						lk=key
					print(str(key)*(r+1), end='')
					break
	print('')