# https://adventofcode.com/2017/day/1

my $YEAR = 2017;
my $DAY = 1;
my $TITLE = 'Inverse Captcha';

print '=== AoC ' . $YEAR . ' Day ' . $DAY . ' : ' . $TITLE . "\n";
# ---------- Part 1
my $line = "91212129";
my $ans1 = 0;
for ($i = 0; $i < length($line); ++$i) {
    if (substr($line, $i, 1) == substr($line, ($i + 1) % length($line), 1)) {
        $ans1 += int(substr($line, $i, 1));
    }
}
print $ans1 . "\n";
# ---------- Part 2
my $line = '12131415';
my $ans2 = 0;
for ($i = 0; $i < length($line); ++$i) {
    if (substr($line, $i, 1) ==substr($line, ($i + length($line) / 2) % length($line), 1)) {
        $ans2 += int(substr($line, $i, 1));
    }
}
print $ans2 . "\n";
