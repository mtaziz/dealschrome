import shelve

def publishStates(db):
    file = '/var/www/stat.html'
    with open(file, 'w+b') as f:
        f.write('<div><h1>Crawling is running: '+repr(db['crawling'])+'</h1></div>')
        for i in db['runtime'].iterkeys():
            f.write('<p><h3>'+i+'</h3></p>')
            for j in db['runtime'][i].iterkeys():
                f.write('<p><strong>'+j+'</strong>: ')
                f.write(repr(db['runtime'][i][j]))
                f.write('</p>')
    print 'done'
