-- https://adventofcode.com/2017/day/1

YEAR = 2017
DAY = 1
TITLE = 'Inverse Captcha'

print('=== AoC ' .. tostring(YEAR) .. ' Day ' .. tostring(DAY) .. ' : ' .. TITLE)
-- ---------- Part 1
line = '91212129'
ans1 = 0
for i = 1, string.len(line) do
    j = (i + 1) % string.len(line)
    if (string.sub(line, i, i) == string.sub(line, j, j)) then
        ans1 = ans1 + tonumber(string.sub(line, i, i))
    end
end
print(ans1)
-- ---------- Part 2
line = '12131415'
ans2 = 0
for i = 1, string.len(line) do
    j = (i + string.len(line) / 2) % string.len(line)
    if (string.sub(line, i, i) == string.sub(line, j, j)) then
        ans2 = ans2 + tonumber(string.sub(line, i, i))
    end
end
print(ans2)
