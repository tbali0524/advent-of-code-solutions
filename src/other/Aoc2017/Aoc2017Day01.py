# https://adventofcode.com/2017/day/1

YEAR = 2017
DAY = 1
TITLE = 'Inverse Captcha'

print('=== AoC ' + str(YEAR) + ' Day ' + str(DAY) + ' : ' + TITLE)
# ---------- Part 1
line = '91212129'
ans1 = 0
for i in range(len(line)):
    if line[i] == line[(i + 1) % len(line)]:
        ans1 += int(line[i])
print(ans1)
#/ ---------- Part 2
line = '12131415'
ans2 = 0
for i in range(len(line)):
    if line[i] == line[(i + len(line) // 2) % len(line)]:
        ans2 += int(line[i])
print(ans2)
