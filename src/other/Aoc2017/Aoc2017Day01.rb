# https://adventofcode.com/2017/day/1

YEAR = 2017
DAY = 1
TITLE = 'Inverse Captcha'

puts '=== AoC ' + YEAR.to_s + ' Day ' + DAY.to_s + ' : ' + TITLE
# ---------- Part 1
line = '91212129'
ans1 = 0
for i in 0..line.length do
    if line[i] == line[(i + 1) % line.length] then
        ans1 += line[i].to_i
    end
end
puts ans1
# ---------- Part 2
line = '12131415'
ans2 = 0
for i in 0..line.length do
    if line[i] == line[(i + line.length / 2) % line.length] then
        ans2 += line[i].to_i
    end
end
puts ans2
