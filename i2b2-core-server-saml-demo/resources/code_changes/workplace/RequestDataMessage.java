/** *****************************************************************************
 * Copyright (c) 2006-2018 Massachusetts General Hospital
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Mozilla Public License,
 * v. 2.0. If a copy of the MPL was not distributed with this file, You can
 * obtain one at http://mozilla.org/MPL/2.0/. I2b2 is also distributed under
 * the terms of the Healthcare Disclaimer.
 ***************************************************************************** */
/*

 *
 * Contributors:
 * 		Raj Kuttan
 * 		Lori Phillips
 * 		Kevin V. Bui - added SAML authentication
 */
package edu.harvard.i2b2.workplace.ws;

import edu.harvard.i2b2.common.exception.I2B2Exception;
import edu.harvard.i2b2.common.util.jaxb.JAXBUtilException;
import edu.harvard.i2b2.workplace.datavo.i2b2message.MessageHeaderType;
import edu.harvard.i2b2.workplace.datavo.i2b2message.RequestMessageType;
import edu.harvard.i2b2.workplace.datavo.i2b2message.SecurityType;
import edu.harvard.i2b2.workplace.util.WorkplaceJAXBUtil;
import edu.harvard.i2b2.workplace.util.WorkplaceUtil;
import javax.sql.DataSource;
import javax.xml.bind.JAXBElement;
import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.dao.DataAccessException;
import org.springframework.jdbc.core.JdbcTemplate;

/**
 * The RequestDataMessage class is a helper class to build Workplace messages in
 * the i2b2 format
 */
public abstract class RequestDataMessage {

    protected final Log log = LogFactory.getLog(getClass());

    public RequestMessageType reqMessageType = null;

    public void setRequestMessageType(String requestWdo) throws I2B2Exception {
        try {
            JAXBElement jaxbElement = WorkplaceJAXBUtil.getJAXBUtil().unMashallFromString(requestWdo);
            this.reqMessageType = (RequestMessageType) jaxbElement.getValue();

        } catch (JAXBUtilException e) {
            throw new I2B2Exception("Umarshaller error: " + e.getMessage()
                    + requestWdo, e);
        }

        setSamlUserToLocalUser();
    }

    private void setSamlUserToLocalUser() throws I2B2Exception {
        SecurityType credentials = getRequestMessageType().getMessageHeader().getSecurity();
        String username = credentials.getUsername().trim();
        if (username.startsWith("saml:")) {
            DataSource dataSource = WorkplaceUtil.getInstance().getDataSource("java:/PMBootStrapDS");
            JdbcTemplate jdbcTemplate = new JdbcTemplate(dataSource);
            String query = "SELECT user_id FROM pm_user_params pup WHERE pup.param_name_cd = 'eppn' AND lower(value) = lower(?)";
            try {
                String localUsername = jdbcTemplate.query(
                        query,
                        ps -> ps.setString(1, username.replaceAll("saml:", "")),
                        rs -> rs.next() ? rs.getString(1) : username);
                credentials.setUsername(localUsername);
            } catch (DataAccessException exception) {
                log.error("Unable to lookup local username using SAML username.", exception);
            }
        }
    }

    public RequestMessageType getRequestMessageType() {
        return reqMessageType;
    }

    public MessageHeaderType getMessageHeaderType() {
        return reqMessageType.getMessageHeader();
    }

}

