import data_extractor

def extract_from_li(xpath,spider,hxs,response):
    desc_list = data_extractor.extractXpathArrays(hxs,xpath)
    sentences = []
    for i in desc_list:
        if i:
            i = i.strip().capitalize()
            i = pre_clean(i)
            if i:
                if i[-1] not in ['.',':',',','!','=','-']:
                    if len(i) > 3:
                        i = i + '.'
                sentences.append(i+' ')
    return ' '.join(sentences)
    
def pre_clean(input_string):
    return input_string\
        .replace('\n',' ')\
        .replace('\t',' ')
